<?php

namespace NoLoCo\Core\Utility\Set;

interface KeyStorageInterface
{
    /**
     * Add a key to the id tree. Set the value of the final
     * position to true.
     * @param string $key
     * @return $this
     */
    public function add(string $key) : self;

    /**
     * Check if a key exists in the tree.
     * @param string $key
     * @return bool
     */
    public function has(string $key) : bool;
}
