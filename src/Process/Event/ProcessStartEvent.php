<?php


namespace NoLoCo\Core\Process\Event;


use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Event\Traits\StoppableEventTrait;
use NoLoCo\Core\Process\ProcessInterface;
use Psr\EventDispatcher\StoppableEventInterface;

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
     * @param ProcessInterface $process
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
     * @param ContextInterface $context
     * @return ProcessStartEvent
     */
    public function setContext(ContextInterface $context): ProcessStartEvent
    {
        $this->context = $context;
        return $this;
    }
}
