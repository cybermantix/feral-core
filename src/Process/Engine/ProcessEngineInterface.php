<?php

namespace Feral\Core\Process\Engine;

use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\ProcessInterface;

/**
 * A process engine manages the flow between the nodes and the
 * events that occur during the process.
 */
interface ProcessEngineInterface
{
    /**
     * Using a set of nodes, edges, and the initial context process each
     * node as determined by the result of the last processed node. The
     * process context (context data inside the process) will
     * override data passed in the context from the driver code.
     *
     * @param ProcessInterface $process
     * @param ContextInterface $context
     * @param string $startNode
     */
    public function process(ProcessInterface $process, ContextInterface $context, string $startNode = 'start'): void;
}
