<?php

namespace NoLoCo\Core\Process\Event;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Event\Traits\StoppableEventTrait;
use NoLoCo\Core\Process\Node\NodeInterface;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * An event for a process node that will be run next.
 * @package NoLoCo\Core\Process\Event
 */
class ProcessNodeBeforeEvent implements StoppableEventInterface
{
    use StoppableEventTrait;

    /**
     * The node to be processed
     * @var NodeInterface
     */
    protected NodeInterface $node;

    /**
     * @var ContextInterface
     */
    protected ContextInterface $context;

    /**
     * @return NodeInterface
     */
    public function getNode(): NodeInterface
    {
        return $this->node;
    }

    /**
     * @param NodeInterface $node
     * @return ProcessNodeBeforeEvent
     */
    public function setNode(NodeInterface $node): self
    {
        $this->node = $node;
        return $this;
    }

    /**
     * @return ContextInterface
     */
    public function getContext(): ContextInterface
    {
        return $this->context;
    }

    /**
     * @param ContextInterface $context
     * @return ProcessNodeBeforeEvent
     */
    public function setContext(ContextInterface $context): self
    {
        $this->context = $context;
        return $this;
    }
}
