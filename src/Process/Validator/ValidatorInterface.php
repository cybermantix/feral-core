<?php

namespace Feral\Core\Process\Validator;

use Feral\Core\Process\Edge\EdgeInterface;
use Feral\Core\Process\Node\NodeInterface;

/**
 * A validator can validate the nodes, edges, and start node when persisting
 * or running a process.
 */
interface ValidatorInterface
{
    /**
     * Validate the nodes, edges, and start key used in a process engine.
     *
     * @param  string          $startKey
     * @param  NodeInterface[] $nodes
     * @param  EdgeInterface[] $edges
     * @return string|null
     */
    public function getValidationError(string $startKey, array $nodes, array $edges): ?string;
}
