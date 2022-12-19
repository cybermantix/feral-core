<?php

namespace Feral\Core\Process\Event;

use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Event\Traits\StoppableEventTrait;
use Feral\Core\Process\Node\NodeInterface;
use Feral\Core\Process\Result\ResultInterface;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * An event from a process after the node has been processed
 * and has a result.
 */
class ProcessNodeAfterEvent implements StoppableEventInterface
{
    use StoppableEventTrait;

    /**
     * The node to be processed
     *
     * @var NodeInterface
     */
    protected NodeInterface $node;

    /**
     * @var ContextInterface
     */
    protected ContextInterface $context;

    /**
     * The result of the node being processed
     *
     * @var ResultInterface
     */
    protected ResultInterface $result;

    /**
     * @return NodeInterface
     */
    public function getNode(): NodeInterface
    {
        return $this->node;
    }

    /**
     * @param  array $node
     * @return ProcessNodeAfterEvent
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
     * @param  ContextInterface $context
     * @return ProcessNodeAfterEvent
     */
    public function setContext(ContextInterface $context): ProcessNodeAfterEvent
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @return ResultInterface
     */
    public function getResult(): ResultInterface
    {
        return $this->result;
    }

    /**
     * @param  ResultInterface $result
     * @return ProcessNodeAfterEvent
     */
    public function setResult(ResultInterface $result): ProcessNodeAfterEvent
    {
        $this->result = $result;
        return $this;
    }
}
