<?php


namespace NoLoCo\Core\Process\Edge;

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
    public function getFromNodeKey(): string;

    /**
     * @param string $fromNodeKey
     * @return $this
     */
    public function setFromNodeKey(string $fromNodeKey): static;

    /**
     * @return string
     */
    public function getToNodeKey(): string;

    /**
     * @param string $toNodeKey
     * @return $this
     */
    public function setToNodeKey(string $toNodeKey): static;
}
