<?php

namespace Nodez\Core\Process\Engine;

use Nodez\Core\Process\Catalog\CatalogInterface;
use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\Edge\EdgeCollection;
use Nodez\Core\Process\Engine\Traits\EdgeCollectionTrait;
use Nodez\Core\Process\Engine\Traits\NodeCodeCollectionTrait;
use Nodez\Core\Process\Engine\Traits\NodeCollectionTrait;
use Nodez\Core\Process\Event\ProcessEndEvent;
use Nodez\Core\Process\Event\ProcessNodeAfterEvent;
use Nodez\Core\Process\Event\ProcessNodeBeforeEvent;
use Nodez\Core\Process\Event\ProcessStartEvent;
use Nodez\Core\Process\Exception\InvalidNodeKey;
use Nodez\Core\Process\Node\NodeCollection;
use Nodez\Core\Process\Node\NodeInterface;
use Nodez\Core\Process\NodeCode\NodeCodeFactory;
use Nodez\Core\Process\NodeCode\NodeCodeInterface;
use Nodez\Core\Process\ProcessInterface;
use Nodez\Core\Process\Result\ResultInterface;
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
    public function process(ProcessInterface $process, string $startNode = 'start'): void
    {
        $this->addNodeCollection($process->getNodes());
        $this->addEdgeCollection($process->getEdges());
        $context = $process->getContext();

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
     * @param  NodeInterface $node
     * @return NodeCodeInterface
     */
    protected function getConfiguredNodeCode(NodeInterface $node): NodeCodeInterface
    {
        $nodeKey = $node->getKey();
        if (empty($this->cachedConfiguredNodeCode[$nodeKey])) {
            $catalogNode = $this->catalog->getCatalogNode($node->getCatalogNodeKey());
            $nodeCode = $this->factory->getNodeCode($catalogNode->getNodeCodeKey());
            // Catalog Overrides Process Node
            $configuration = array_merge($node->getConfiguration(), $catalogNode->getConfiguration());
            $nodeCode->addConfiguration($configuration);
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
