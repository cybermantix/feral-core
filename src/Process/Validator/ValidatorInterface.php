<?php

namespace NoLoCo\Core\Process\Validator;

use NoLoCo\Core\Process\Edge\EdgeInterface;
use NoLoCo\Core\Process\Node\NodeInterface;

/**
 * A validator can validate the nodes, edges, and start node when persisting
 * or running a process.
 */
interface ValidatorInterface
{
    /**
     * Validate the nodes, edges, and start key used in a process engine.
     * @param string $startKey
     * @param NodeInterface[] $nodes
     * @param EdgeInterface[] $edges
     * @return string|null
     */
    public function getValidationError(string $startKey, array $nodes, array $edges): ?string;
}