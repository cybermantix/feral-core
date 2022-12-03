<?php

namespace Nodez\Core\Process;

use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\Edge\EdgeInterface;
use Nodez\Core\Process\Node\NodeInterface;

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
