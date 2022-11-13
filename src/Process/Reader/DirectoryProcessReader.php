<?php

namespace NoLoCo\Core\Process\Reader;

use Exception;
use NoLoCo\Core\Process\ProcessJsonHydrator;
use NoLoCo\Core\Process\ProcessSourceInterface;

/**
 * Read a directory of process files and return Process objects.
 */
class DirectoryProcessReader implements ProcessSourceInterface
{
    public function __construct(
        /**
         * The directory to read to builder the processes
         */
        private string $directory,
        private ProcessJsonHydrator $hydrator
    ){}

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getProcesses(): array
    {
        $processes = [];
        $directoryContent = array_diff(scandir($this->directory), array('..', '.'));
        foreach ($directoryContent as $file) {
            $jsonString = file_get_contents($this->directory . DIRECTORY_SEPARATOR . $file);
            $processes[] = $this->hydrator->hydrate($jsonString);
        }
        return $processes;
    }
}