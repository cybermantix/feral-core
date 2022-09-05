<?php

namespace NoLoCo\Core\Process\Definition;
use NoLoCo\Core\Process\Edge\EdgeInterface;

/**
 * A meta object that describes a process and
 * can be persisted in a file, database, or API.
 */
interface DefinitionInterface
{
    /**
     * The alpha, numeric, underscore unique key
     * that identifies this process. This key cannot
     * be changed after it's created.
     * @return string
     */
    public function getKey(): string;

    /**
     * The version of the process.
     * @return int
     */
    public function version(): int;

    /**
     * The name of the process being built. This name
     * is used for logging and errors only.
     * @return string
     */
    public function getName(): string;

    /**
     * The list of node definitions for the process. The node
     * definitions describe the unique set of nodes available
     * in the process.
     * @return NodeDefinitionInterface[]
     */
    public function getNodeDefinitions(): array;

    /**
     * The edge definitions
     * @return EdgeInterface[]
     */
    public function getEdgeDefinitions(); array;
}