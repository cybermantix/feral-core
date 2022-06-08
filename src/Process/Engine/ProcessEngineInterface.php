<?php

namespace NoLoCo\Core\Process\Engine;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Edge\EdgeInterface;
use NoLoCo\Core\Process\Node\NodeInterface;

/**
 * A process engine manages the flow between the nodes and the
 * events that occur during the process.
 */
interface ProcessEngineInterface
{
    /**
     * Using a set of nodes, edges, and the initial context process each
     * node as determined by the result of the last processed node.
     * @param string $startNodeKey
     * @param NodeInterface[] $nodes
     * @param EdgeInterface[] $edges
     * @param ContextInterface $context
     */
    public function process(string $startNodeKey, array $nodes, array $edges, ContextInterface $context):void;

}