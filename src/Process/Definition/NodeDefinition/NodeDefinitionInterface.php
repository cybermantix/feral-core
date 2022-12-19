<?php

namespace Feral\Core\Process\Definition\NodeDefinition;

/**
 * A node definition is a description of a node and can
 * be serialized and persisted in a file, database, or
 * network API.
 */
interface NodeDefinitionInterface
{
    /**
     * The key for this node referenced by edges in the
     * process. It must be unique in the process.
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * The type of node used to execute code at this
     * step in the process.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * The Key/Value pair used to configure the node.
     *
     * @return array
     */
    public function getConfiguration(): array;

    /**
     * The mapping of result keys to the next nodes reference
     * by key.
     *
     * @return array
     */
    public function getResultEdges(): array;
}
