<?php

namespace Feral\Core\Process\Event\Traits;

trait StoppableEventTrait
{
    private bool $propagationStopped = false;


    /**
     * {@inheritdoc}
     */
    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    /**
     *
     */
    public function stopPropagation(): void
    {
        $this->propagationStopped = true;
    }
}
