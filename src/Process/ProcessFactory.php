<?php

namespace NoLoCo\Core\Process;

use Exception;
use NoLoCo\Core\Process\Catalog\CatalogSource\CatalogSourceInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

/**
 * Aggregate the process sources allowing the user to find
 * one process in the list.
 */
class ProcessFactory
{
    /**
     * @var ProcessSourceInterface[]
     */
    protected array $sources = [];

    /**
     * A cache to store the found node in the sources.
     * @var ProcessSourceInterface[]
     */
    protected array $cache = [];

    public function __construct(
        #[TaggedIterator('noloco.process_source')] iterable $sources
    )
    {
        foreach ($sources as $source) {
            $this->sources[] = $source;
        }
    }

    /**
     * Get a process by its key. search through the process
     * sources to find the processes.
     * @throws Exception
     */
    public function build(string $key): ProcessInterface
    {
        $found = false;
        if (empty($this->cache[$key])) {
            foreach ($this->sources as $source) {
                $processes = $source->getProcesses();
                foreach ($processes as $process) {
                    if ($process->getKey() === $key) {
                        $this->cache[$key] = $process;
                        $found = true;
                        break;
                    }
                }
                if ($found) {
                    break;
                }
            }
            if (!$found) {
                throw new Exception(sprintf('Cannot find process with key "%s"', $key));
            }
        }
        return $this->cache[$key];
    }

    public function getAllProcesses(): array
    {
        $allProcesses = [];
        foreach ($this->sources as $source) {
            $allProcesses = array_merge($allProcesses, $source->getProcesses());
        }
        return $allProcesses;
    }
}