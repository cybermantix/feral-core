<?php

namespace Feral\Core\Process\Event;

use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Event\Traits\StoppableEventTrait;
use Feral\Core\Process\ProcessInterface;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * The event that is dispatched before the process starts.
 */
class ProcessStartEvent implements StoppableEventInterface
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
     * @return ProcessStartEvent
     */
    public function setProcess(ProcessInterface $process): ProcessStartEvent
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
    public function setContext(ContextInterface $context): ProcessStartEvent
    {
        $this->context = $context;
        return $this;
    }
}
