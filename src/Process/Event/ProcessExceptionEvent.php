<?php

namespace NoLoCo\Core\Process\Event;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Process\Result\ResultInterface;
use Exception;
use Symfony\Contracts\EventDispatcher\Event;
use Throwable;

class ProcessExceptionEvent extends Event
{
    /**
     * The node to be processed
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
     * @param array $node
     * @return ProcessNodeAfterEvent
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
     * @param ContextInterface $context
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
     * @param Throwable $throwable
     * @return self
     */
    public function setThrowable(Throwable $throwable): self
    {
        $this->throwable = $throwable;
        return $this;
    }
}
