<?php

namespace NoLoCo\Core\Process\Event;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Engine\ProcessEngineInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ProcessEndEvent extends Event
{

    protected ProcessEngineInterface $process;

    /**
     * @var ContextInterface
     */
    protected ContextInterface $context;

    /**
     * @return ProcessEngineInterface
     */
    public function getProcess(): ProcessEngineInterface
    {
        return $this->process;
    }

    /**
     * @param ProcessEngineInterface $process
     * @return ProcessEndEvent
     */
    public function setProcess(ProcessEngineInterface $process): ProcessEndEvent
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
     * @param ContextInterface $context
     * @return ProcessStartEvent
     */
    public function setContext(ContextInterface $context): self
    {
        $this->context = $context;
        return $this;
    }
}
