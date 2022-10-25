<?php

namespace NoLoCo\Core\Process\Engine;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Edge\EdgeCollection;
use NoLoCo\Core\Process\Engine\Traits\EdgeCollectionTrait;
use NoLoCo\Core\Process\Engine\Traits\NodeCodeCollectionTrait;
use NoLoCo\Core\Process\Event\ProcessEndEvent;
use NoLoCo\Core\Process\Event\ProcessNodeAfterEvent;
use NoLoCo\Core\Process\Event\ProcessNodeBeforeEvent;
use NoLoCo\Core\Process\Event\ProcessStartEvent;
use NoLoCo\Core\Process\NodeCode\NodeCodeCollection;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Process\Result\Result;
use NoLoCo\Core\Process\Result\ResultInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class ProcessEngine implements ProcessEngineInterface
{
    use EdgeCollectionTrait, NodeCodeCollectionTrait;

    /**
     * @var NodeCodeInterface[]
     */
    private array $nodes = [];

    /**
     * Process constructor.
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        protected EventDispatcherInterface $eventDispatcher
    )
    {
        $this->edgeCollection = new EdgeCollection();
        $this->nodeCodeCollection = new NodeCodeCollection();
    }

    /**
     * @throws \NoLoCo\Core\Process\Exception\InvalidNodeCodeKey
     */
    public function process(string $startNodeKey, array $nodes, array $edges, ContextInterface $context): void
    {
        $this->addNodeCodeCollection($nodes);
        $this->addEdgeCollection($edges);

        $this->eventDispatcher->dispatch(
            (new ProcessStartEvent())
                ->setContext($context)
                ->setProcess($this)
        );

        // START NODE
        $node = $this->getNodeCodeByKey($startNodeKey);
        if (!$node) {
            throw new ProcessException('The start node does not exist.');
        }

        $result = $this->processNode($node, $context);
        $continue = true;
        while ($continue) {
            $edge = $this->getEdgeByNodeAndResult($node->getKey(), $result->getStatus());
            $node = $this->getNodeCodeByKey($edge->getToKey());
            $result = $this->processNode($node, $context);
            if (ResultInterface::STOP === $result->getStatus()) {
                $continue = false;
            }
        }
        $this->eventDispatcher->dispatch(
            (new ProcessEndEvent())
                ->setContext($context)
                ->setProcess($this)
        );
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