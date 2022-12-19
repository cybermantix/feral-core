<?php

namespace Feral\Core\Process\Engine;

use Feral\Core\Process\ProcessInterface;

/**
 * A process engine manages the flow between the nodes and the
 * events that occur during the process.
 */
interface ProcessEngineInterface
{
    /**
     * Using a set of nodes, edges, and the initial context process each
     * node as determined by the result of the last processed node.
     *
     * @param ProcessInterface $process
     */
    public function process(ProcessInterface $process, string $startNode = 'start'): void;
}
