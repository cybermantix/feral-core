<?php

namespace NoLoCo\Core\Process\NodeCode\Configuration\Description;

/**
 * A description of a configuration value.
 */
interface ConfigurationDescriptionInterface
{
    /**
     * The type of the configuration is a string.
     */
    const STRING = 'string';
    /**
     * The type of the configuration is an int.
     */
    const INT = 'int';
    /**
     * The type of the configuration is a float.
     */
    const FLOAT = 'float';
    /**
     * The type of the configuration is an array of strings.
     */
    const STRING_ARRAY = 'string_array';
    /**
     * The type of the configuration is an array of int.
     */
    CONST INT_ARRAY = 'int_array';
    /**
     * The type of the configuration is an array of floats.
     */
    CONST FLOAT_ARRAY = 'float_array';

    /**
     * The key of the configuration value
     * @return string
     */
    function getKey(): string;

    /**
     * The human friendly name for this configuration
     * @return string
     */
    function getName(): string;

    /**
     * The human friendly description for this configuration
     * @return string
     */
    function getDescription(): string;

    /**
     * The type of configuration value.
     * @return string
     */
    function getType(): string;

    /**
     * Test if a value is a valid configuration value.
     * @param mixed $value
     * @return bool
     */
    function isValid(mixed $value): bool;
}