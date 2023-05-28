<?php

namespace Feral\Core\Process\Modification;

/**
 * Modify a process configuration with a modification
 * configuration.
 */
interface JSONModificationInterface
{
    /**
     * The delete key in a modification to remove a node, context value,
     * or result.
     */
    const DELETE = '_DELETE_';
    /**
     * The JSON property to search for to delete a node.
     */
    const DELETE_KEY = 'delete';
    /**
     * There are parts of a configuration that are not allowed to be
     * modified.
     */
    const DISALLOWED_PROPERTIES = ['schema_version', 'key', 'version'];
    /**
     * Modify a process configuration json string with another json string.
     * @param string $configuration
     * @param string $modification
     * @return string
     */
    public function modify (string $configuration, string $modification): string;
}