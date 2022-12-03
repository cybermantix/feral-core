<?php

namespace Nodez\Core\Process\Event;

use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\Event\Traits\StoppableEventTrait;
use Nodez\Core\Process\NodeCode\NodeCodeInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Throwable;

/**
 * The event that is dispatched when an exception occurs.
 */
class ProcessExceptionEvent implements StoppableEventInterface
{
    use StoppableEventTrait;

    /**
     * The node to be processed
     *
     * @var NodeCodeInterface
     */
    protected NodeCodeInterface $node;

    /**
     * @var ContextInterface
     */
    protected ContextInterface $context;

    /**
     * @var Throwable
     */
    protected Throwable $throwable;

    /**
     * @return array
     */
    public function getNode(): NodeCodeInterface|array
    {
        return $this->node;
    }

    /**
     * @param  NodeCodeInterface|array $node
     * @return ProcessExceptionEvent
     */
    public function setNode(NodeCodeInterface|array $node): self
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
    public function setContext(ContextInterface $context): self
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @return Throwable
     */
    public function getThrowable(): Throwable
    {
        return $this->throwable;
    }

    /**
     * @param  Throwable $throwable
     * @return self
     */
    public function setThrowable(Throwable $throwable): self
    {
        $this->throwable = $throwable;
        return $this;
    }
}
