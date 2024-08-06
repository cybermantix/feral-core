<?php

namespace Feral\Core\Process\Node;

/**
 * A node is a place in the process that processes
 * the context.
 */
interface NodeInterface
{
    /**
     * The unique key within a process which
     * identifies this node;
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * The human description for this node;
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * The key for the catalog node this process node
     * references.
     *
     * @return string
     */
    public function getCatalogNodeKey(): string;

    /**
     * Get the configuration key/values for the node
     * code. This will override the catalog node configuration
     * and node code configuration.
     *
     * @return array
     */
    public function getConfiguration(): array;
}
