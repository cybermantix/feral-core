<?php

namespace NoLoCo\Core\Process\Engine;

use NoLoCo\Core\Process\Catalog\CatalogInterface;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Edge\EdgeCollection;
use NoLoCo\Core\Process\Engine\Traits\EdgeCollectionTrait;
use NoLoCo\Core\Process\Engine\Traits\NodeCodeCollectionTrait;
use NoLoCo\Core\Process\Engine\Traits\NodeCollectionTrait;
use NoLoCo\Core\Process\Event\ProcessEndEvent;
use NoLoCo\Core\Process\Event\ProcessNodeAfterEvent;
use NoLoCo\Core\Process\Event\ProcessNodeBeforeEvent;
use NoLoCo\Core\Process\Event\ProcessStartEvent;
use NoLoCo\Core\Process\Exception\InvalidNodeCodeKey;
use NoLoCo\Core\Process\Exception\InvalidNodeKey;
use NoLoCo\Core\Process\Node\NodeCollection;
use NoLoCo\Core\Process\Node\NodeInterface;
use NoLoCo\Core\Process\NodeCode\NodeCodeFactory;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Process\Result\ResultInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class ProcessEngine implements ProcessEngineInterface
{
    use EdgeCollectionTrait, NodeCodeCollectionTrait, NodeCollectionTrait;

    /**
     * A cached version of a node that has been configured.
     * @var array
     */
    protected array $cachedConfiguredNodeCode = [];

    /**
     * Process constructor.
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        protected EventDispatcherInterface $eventDispatcher,
        protected CatalogInterface $catalog,
        protected NodeCodeFactory $factory
    )
    {
        $this->edgeCollection = new EdgeCollection();
        $this->nodeCollection = new NodeCollection();
    }

    /**
     * @inheritDoc
     * @throws InvalidNodeCodeKey
     * @throws InvalidNodeKey
     */
    public function process(string $startNodeKey, array $nodes, array $edges, ContextInterface $context): void
    {
        $this->addNodeCollection($nodes);
        $this->addEdgeCollection($edges);

        $this->eventDispatcher->dispatch(
            (new ProcessStartEvent())
                ->setContext($context)
                ->setProcess($this)
        );

        // START NODE
        $node = $this->getNodeByKey($startNodeKey);

        $result = $this->processNode($node, $context);
        while (ResultInterface::STOP !== $result->getStatus()) {
            $edge = $this->getEdgeByNodeAndResult($node->getKey(), $result->getStatus());
            $node = $this->getNodeByKey($edge->getToKey());
            $result = $this->processNode($node, $context);
        }
        $this->eventDispatcher->dispatch(
            (new ProcessEndEvent())
                ->setContext($context)
                ->setProcess($this)
        );
    }

    /**
     * Get the configured node by using the process node
     * key
     * @param string $key
     * @return NodeCodeInterface
     * @throws InvalidNodeKey
     */
    protected function getNodeByKey(string $key): NodeCodeInterface
    {
        $node = $this->nodeCollection->getNodeByKey($key);
        return $this->getConfiguredNodeCode($node);
    }

    /**
     * An internal function used to get the catalog node, the node code
     * and configure it. This will use an internal cache for nodes that
     * get processed multiple times.
     * @param NodeInterface $node
     * @return NodeCodeInterface
     */
    protected function getConfiguredNodeCode(NodeInterface $node): NodeCodeInterface
    {
        $nodeKey = $node->getKey();
        if (empty($this->cachedConfiguredNodeCode[$nodeKey])) {
            $catalogNode = $this->catalog->getCatalogNode($node->getCatalogNodeKey());
            $nodeCode = $this->factory->getNodeCode($catalogNode->getNodeCodeKey());
            $nodeCode
                ->addConfiguration($catalogNode->getConfiguration())
                ->addConfiguration($node->getConfiguration());
            $this->cachedConfiguredNodeCode[$nodeKey] = $nodeCode;
        }
        return $this->cachedConfiguredNodeCode[$nodeKey];
    }

    /**
     * Process a node, dispatch the events, and return the results
     * @param NodeCodeInterface $nodeCode
     * @param ContextInterface $context
     * @return ResultInterface
     */
    protected function processNode(NodeCodeInterface $nodeCode, ContextInterface $context): ResultInterface
    {
        $this->eventDispatcher->dispatch(
            (new ProcessNodeBeforeEvent())
                ->setContext($context)
                ->setNode($nodeCode)
        );

        $result = $nodeCode->process($context);

        $this->eventDispatcher->dispatch(
            (new ProcessNodeAfterEvent())
                ->setContext($context)
                ->setNode($nodeCode)
        );
        return $result;
    }
}