<?php

namespace NoLoCo\Core\Process\Definition;
/**
 * A meta object that describes a process and
 * can be persisted in a file, database, or API.
 */
interface DefinitionInterface
{
    /**
     * The name of the process being built. This name
     * is used for logging and errors only.
     * @return string
     */
    public function getName():string;

    /**
     * The list of node definitions for the process.
     * @return NodeDefinitionInterface[]
     */
    public function getNodeDefinitions():array;
}