<?php

namespace Nodez\Core\Process\Event;

use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\Event\Traits\StoppableEventTrait;
use Nodez\Core\Process\ProcessInterface;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * The event that is dispatched after the process ends.
 */
class ProcessEndEvent implements StoppableEventInterface
{
    use StoppableEventTrait;

    protected ProcessInterface $process;

    /**
     * @var ContextInterface
     */
    protected ContextInterface $context;

    /**
     * @return ProcessInterface
     */
    public function getProcess(): ProcessInterface
    {
        return $this->process;
    }

    /**
     * @param  ProcessInterface $process
     * @return ProcessEndEvent
     */
    public function setProcess(ProcessInterface $process): ProcessEndEvent
    {
        $this->process = $process;
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
     * @return ProcessStartEvent
     */
    public function setContext(ContextInterface $context): self
    {
        $this->context = $context;
        return $this;
    }
}
