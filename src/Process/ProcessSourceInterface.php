<?php

namespace Nodez\Core\Process;

/**
 * Define the interface for an object that can be a
 * source of processes.
 */
interface ProcessSourceInterface
{
    /**
     * @return ProcessInterface[]
     */
    public function getProcesses(): array;
}
