<?php

namespace NoLoCo\Core\Process;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Edge\EdgeInterface;
use NoLoCo\Core\Process\Node\NodeInterface;

/**
 * A process is an entity that holds the nodes, edges,
 * and initial context.
 */
interface ProcessInterface
{
    /**
     * The identifying key for this process in the system.
     */
    public function getKey(): string;
    /**
     * Get the initial context used in the process engine.
     *
     * @return ContextInterface
     */
    public function getContext(): ContextInterface;
    /**
     * Get the process nodes used in the process engine.
     *
     * @return NodeInterface[]
     */
    public function getNodes(): array;

    /**
     * The edges that stitch together the nodes based on
     * the results.
     *
     * @return EdgeInterface[]
     */
    public function getEdges(): array;
}
