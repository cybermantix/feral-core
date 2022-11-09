<?php

namespace NoLoCo\Core\Process\Reader;

use NoLoCo\Core\Process\ProcessInterface;

/**
 * Get a set of available processes.
 */
interface ProcessReaderInterface
{
    /**
     * @return ProcessInterface[]
     */
    public function getProcesses(): array;
}