<?php

namespace NoLoCo\Core\Process\Engine;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Edge\EdgeInterface;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class SimpleProcessEngine implements ProcessEngineInterface
{
    /**
     * Process constructor.
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        protected EventDispatcherInterface $eventDispatcher
    )
    {
        $this->edges = new EdgeCollection();
    }

    public function process(string $startNodeKey, array $nodes, array $edges, ContextInterface $context): void
    {
        if (empty($this->startNodeKey)) {
            throw new ProcessException('The start node key must be defined.');
        }

        $this->eventDispatcher->dispatch(
            (new ProcessStartEvent())
                ->setContext($context)
                ->setProcess($this)
        );
        $node = $this->getNode($this->startNodeKey);
        $this->doProcess($node, $context);
        $this->eventDispatcher->dispatch(
            (new ProcessEndEvent())
                ->setContext($context)
                ->setProcess($this)
        );
    }

}