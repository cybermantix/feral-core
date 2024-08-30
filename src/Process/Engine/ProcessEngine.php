<?php

namespace Feral\Core\Process\Engine;

use Exception;
use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Catalog\CatalogInterface;
use Feral\Core\Process\Configuration\ConfigurationValue;
use Feral\Core\Process\Configuration\ConfigurationValueType;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Edge\EdgeCollection;
use Feral\Core\Process\Engine\Traits\EdgeCollectionTrait;
use Feral\Core\Process\Engine\Traits\NodeCodeCollectionTrait;
use Feral\Core\Process\Engine\Traits\NodeCollectionTrait;
use Feral\Core\Process\Event\ProcessEndEvent;
use Feral\Core\Process\Event\ProcessNodeAfterEvent;
use Feral\Core\Process\Event\ProcessNodeBeforeEvent;
use Feral\Core\Process\Event\ProcessStartEvent;
use Feral\Core\Process\Exception\InvalidNodeKey;
use Feral\Core\Process\Node\NodeCollection;
use Feral\Core\Process\Node\NodeInterface;
use Feral\Core\Process\NodeCode\NodeCodeFactory;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\ProcessInterface;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\ResultInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @see ProcessEngineInterface
 */
class ProcessEngine implements ProcessEngineInterface
{
    use EdgeCollectionTrait;
    use NodeCodeCollectionTrait;
    use NodeCollectionTrait;

    /**
     * A cached version of a node that has been configured.
     *
     * @var array
     */
    protected array $cachedConfiguredNodeCode = [];

    /**
     * Process constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        protected EventDispatcherInterface $eventDispatcher,
        protected CatalogInterface $catalog,
        protected NodeCodeFactory $factory
    ) {
        $this->edgeCollection = new EdgeCollection();
        $this->nodeCollection = new NodeCollection();
    }

    /**
     * @inheritDoc
     * @throws     InvalidNodeKey
     */
    public function process(ProcessInterface $process, ContextInterface $context, string $startNode = 'start'): void
    {
        $this->addNodeCollection($process->getNodes());
        $this->addEdgeCollection($process->getEdges());
        $processContext = $process->getContext();

        // ADD PROCESS CONTEXT
        // OVERRIDE ANY RUNTIME CONTEXT VALUES!
        foreach($processContext->getAll() as $key => $value) {
            $context->set($key, $value);
        }

        $this->eventDispatcher->dispatch(
            (new ProcessStartEvent())
                ->setContext($context)
                ->setProcess($process)
        );

        // START NODE
        $node = $this->nodeCollection->getNodeByKey($startNode);
        $nodeCode = $this->getNodeCodeByKey($startNode);
        $processNodeKey = $startNode;
        $result = $this->processNode($node, $nodeCode, $context);
        while (ResultInterface::STOP !== $result->getStatus()) {
            $edge = $this->getEdgeByNodeAndResult($processNodeKey, $result->getStatus());
            $processNodeKey = $edge->getToKey();
            $node = $this->nodeCollection->getNodeByKey($processNodeKey);
            $nodeCode = $this->getNodeCodeByKey($processNodeKey);
            $result = $this->processNode($node, $nodeCode, $context);
        }
        $this->eventDispatcher->dispatch(
            (new ProcessEndEvent())
                ->setContext($context)
                ->setProcess($process)
        );
    }

    /**
     * Get the configured node by using the process node
     * key
     *
     * @param  string $key
     * @return NodeCodeInterface
     * @throws InvalidNodeKey
     */
    protected function getNodeCodeByKey(string $key): NodeCodeInterface
    {
        $node = $this->nodeCollection->getNodeByKey($key);
        return $this->getConfiguredNodeCode($node);
    }

    /**
     * An internal function used to get the catalog node, the node code
     * and configure it. This will use an internal cache for nodes that
     * get processed multiple times.
     *
     * @param NodeInterface $node
     * @return NodeCodeInterface
     * @throws Exception
     */
    protected function getConfiguredNodeCode(NodeInterface $node): NodeCodeInterface
    {
        $nodeKey = $node->getKey();
        if (empty($this->cachedConfiguredNodeCode[$nodeKey])) {
            $catalogNode = $this->catalog->getCatalogNode($node->getCatalogNodeKey());
            $nodeCode = $this->factory->getNodeCode($catalogNode->getNodeCodeKey());

            // description attributes
            $nodeCodeReflection = new \ReflectionClass($nodeCode::class);
            $nodeCodeAttributes = $nodeCodeReflection->getAttributes();
            $configurationDescriptions = [];
            $requiredValues = [];
            foreach ($nodeCodeAttributes as $attribute) {
                $instance = $attribute->newInstance();
                if (is_a($instance, ConfigurationDescriptionInterface::class)) {
                    $configurationDescriptions[$instance->getKey()] = $instance;
                    if (!$instance->hasDefault() && !$instance->isOptional()) {
                        $requiredValues[] = $instance->getKey();
                    }
                }
            }

            $configurationValues = [];
            foreach ($configurationDescriptions as $key => $value) {
                if (!$value->isSecret()) {
                    $type = $value->isOptional() ?
                        ConfigurationValueType::OPTIONAL:
                        ConfigurationValueType::STANDARD;
                } else {
                    $type = $value->isOptional() ?
                        ConfigurationValueType::OPTIONAL_SECRET:
                        ConfigurationValueType::SECRET;
                }
                $configurationValue = (new ConfigurationValue())
                    ->setKey($key)
                    ->setType($type);

                if ($value->hasDefault()) {
                    $configurationValue->setDefault($value->getDefault());
                    $requiredValues = array_diff($requiredValues, [$key]);
                }
                $configurationValues[$key] = $configurationValue;
            }

            $configurationKeys = array_keys($configurationValues);
            $badKeys = array_diff(array_keys($catalogNode->getConfiguration()), $configurationKeys);
            if (!empty($badKeys)) {
                throw new Exception(sprintf(
                    'Catalog configuration "%s" keys "%s" are not present in the configuration for the node. Valid configuration keys are "%s"',
                    $catalogNode->getKey(),
                    implode(", ",$badKeys),
                    implode(", ",$configurationKeys)
                ));
            }

            $badKeys = array_diff(array_keys($node->getConfiguration()), $configurationKeys);
            if (!empty($badKeys)) {
                throw new Exception(sprintf(
                    'Process configuration "%s" keys "%s" are not present in the configuration for the node. Valid configuration keys are "%s"',
                    $nodeKey,
                    implode(", ",$badKeys),
                    implode(", ",$configurationKeys)
                ));
            }


            // Catalog Overrides Process Node
            $configuration = array_merge($catalogNode->getConfiguration(), $node->getConfiguration());
            foreach ($configuration as $key => $value) {
                $configurationValues[$key]->setValue($value);
                $requiredValues = array_diff($requiredValues, [$key]);
            }

            if (!empty($requiredValues)) {
                throw new Exception(
                    sprintf(
                        'Required configuration values "%s" are missing for node "%s" and catalog node "%s".',
                        implode(",", $requiredValues),
                        $node->getKey(),
                        $catalogNode->getKey()
                    )
                );
            }

            // CONFIRM ALL CONFIGURATIONS HAVE VALUES
            $nodeCode->addConfiguration($configurationValues);
            $this->cachedConfiguredNodeCode[$nodeKey] = $nodeCode;
        }
        return $this->cachedConfiguredNodeCode[$nodeKey];
    }

    /**
     * Process a node, dispatch the events, and return the results
     *
     * @param  NodeInterface     $node
     * @param  NodeCodeInterface $nodeCode
     * @param  ContextInterface  $context
     * @return ResultInterface
     */
    protected function processNode(NodeInterface $node, NodeCodeInterface $nodeCode, ContextInterface $context): ResultInterface
    {
        $this->eventDispatcher->dispatch(
            (new ProcessNodeBeforeEvent())
                ->setContext($context)
                ->setNode($node)
        );

        $result = $nodeCode->process($context);

        $this->eventDispatcher->dispatch(
            (new ProcessNodeAfterEvent())
                ->setContext($context)
                ->setNode($node)
                ->setResult($result)
        );
        return $result;
    }
}
