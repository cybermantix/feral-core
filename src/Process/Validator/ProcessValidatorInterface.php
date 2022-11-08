<?php

namespace NoLoCo\Core\Process\Validator;

use NoLoCo\Core\Process\Edge\EdgeInterface;
use NoLoCo\Core\Process\Node\NodeInterface;

/**
 * Run the nodes, edges, and start key against all the available
 * validators.
 */
interface ProcessValidatorInterface
{
    /**
     * Validate the nodes, edges, and start key used in a process engine.
     * @param string $startKey
     * @param NodeInterface[] $nodes
     * @param EdgeInterface[] $edges
     * @return string[]
     */
    public function validate(string $startKey, array $nodes, array $edges): array;

}