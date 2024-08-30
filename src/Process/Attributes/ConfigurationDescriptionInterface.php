<?php

namespace Feral\Core\Process\Attributes;

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
     * The type of the configuration is a boolean.
     */
    const BOOLEAN = 'boolean';
    /**
     * The type of the configuration is an array of strings.
     */
    const STRING_ARRAY = 'string_array';
    /**
     * The type of the configuration is an array of int.
     */
    const INT_ARRAY = 'int_array';
    /**
     * The type of the configuration is an array of floats.
     */
    const FLOAT_ARRAY = 'float_array';

    /**
     * The key of the configuration value
     *
     * @return string
     */
    public function getKey(): string;

    /**
     * The human friendly name for this configuration
     *
     * @return string
     */
    public function getName(): string;

    /**
     * The human friendly description for this configuration
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * The type of configuration value.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * The default value for the configuration.
     * @return mixed
     */
    public function getDefault(): mixed;

    /**
     * Does the configuation description have a default?
     */
    public function hasDefault(): bool;

    /**
     * Is this configuration a secret?
     * @return bool
     */
    public function isSecret(): bool;

    /**
     * Is this configuration optional?
     * @return bool
     */
    public function isOptional(): bool;

    /**
     * Test if a value is a valid configuration value.
     *
     * @param  mixed $value
     * @return bool
     */
    public function isValid(mixed $value): bool;
}
