<?php

namespace Nodez\Core\Process;

use Nodez\Core\Process\ProcessSourceInterface;

/**
 * A generic process source that will hold a collection
 * of processes and return using the interface's get processes
 * method.
 */
class ProcessSource implements ProcessSourceInterface
{

    public function __construct(
        private iterable $sources = []
    ){
        $this->sources = iterator_to_array($sources);
    }

    /**
     * @inheritDoc
     */
    public function getProcesses(): array
    {
        return $this->sources;
    }
}