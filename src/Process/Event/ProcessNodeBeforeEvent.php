<?php

namespace NoLoCo\Core\Process\Event;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Node\NodeInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * An event for a process node that will be run next.
 * @package NoLoCo\Core\Process\Event
 */
class ProcessNodeBeforeEvent extends Event
{
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
