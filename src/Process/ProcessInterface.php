<?php

namespace Feral\Core\Process;

use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Edge\EdgeInterface;
use Feral\Core\Process\Node\NodeInterface;

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
     * Information on what the process does
     */
    public function getDescription(): string;
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
