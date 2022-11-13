<?php

namespace NoLoCo\Core\Process;

interface ProcessSourceInterface
{
    /**
     * @return ProcessInterface[]
     */
    public function getProcesses(): array;
}