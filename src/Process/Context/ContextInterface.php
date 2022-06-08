<?php

namespace NoLoCo\Core\Process\Context;

/**
 * A process context is a set of data that is passed from node
 * to node keeping state and data used in work nodes. The context
 * contains an array that can have strings, numbers, and arrays,
 * and numbers.
 *
 * - Notes about the key:
 * -- Use lower case
 * -- Use snake case (one_two_three)
 *
 */
interface ContextInterface
{
    /**
     * Set a particular value into the context with a key.
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set(string $key, mixed $value): static;

    /**
     * Get a particular value using its key
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed;

    /**
     * Check if a particular key is set.
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Remove a key and value if it exists.
     * @param string $key
     * @return $this
     */
    public function remove(string $key): static;

    /**
     * Get all the data stored in the context
     * @return array
     */
    public function getAll(): array;

    /**
     * Unset a variable in the context. If there was a value
     * set in the context then return true else return false.
     * @param string $key
     * @return bool
     */
    public function clear(string $key): bool;

    /**
     * Get an int value from the context
     * @param string $key
     * @return int
     */
    public function getInt(string $key): int;

    /**
     * Get a float value from the context
     * @param string $key
     * @return float
     */
    public function getFloat(string $key): float;

    /**
     * Get a string value from the context
     * @param string $key
     * @return string
     */
    public function getString(string $key): string;

    /**
     * Get an array value from the context
     * @param string $key
     * @return array
     */
    public function getArray(string $key): array;

    /**
     * Get an object from the context and check the type
     * @param string $key
     * @param string $type
     * @return mixed
     */
    public function getObject(string $key, string $type): object;
}