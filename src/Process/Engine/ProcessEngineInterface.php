<?php

namespace NoLoCo\Core\Process\Engine;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Edge\EdgeInterface;
use NoLoCo\Core\Process\Node\NodeInterface;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Process\ProcessInterface;

/**
 * A process engine manages the flow between the nodes and the
 * events that occur during the process.
 */
interface ProcessEngineInterface
{
    /**
     * Using a set of nodes, edges, and the initial context process each
     * node as determined by the result of the last processed node.
     * @param ProcessInterface $process
     */
    public function process(ProcessInterface $process, string $startNode = 'start'):void;

}