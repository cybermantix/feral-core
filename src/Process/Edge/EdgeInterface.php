<?php

namespace Feral\Core\Process\Edge;

/**
 * An edge is the glue between different nodes. It's a connector
 * between different nodes based on the result of a node after the
 * node is processed.
 * Interface EdgeInterface
 */
interface EdgeInterface
{
    /**
     * @return string
     */
    public function getFromKey(): string;

    /**
     * @param  string $fromNodeKey
     * @return $this
     */
    public function setFromKey(string $fromNodeKey): static;

    /**
     * @return string
     */
    public function getToKey(): string;

    /**
     * @param  string $toNodeKey
     * @return $this
     */
    public function setToKey(string $toNodeKey): static;

    /**
     * Get the result to select the node
     *
     * @return string
     */
    public function getResult(): string;

    /**
     * Set the result used to select this edge
     *
     * @param  string $result
     * @return $this
     */
    public function setResult(string $result): static;
}
