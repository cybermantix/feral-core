<?php

namespace NoLoCo\Core\Process\NodeCode\Configuration\Description;

/**
 * Use this configuration description for configuration values that are
 * a string.
 */
class IntConfigurationDescription extends AbstractConfigurationDescription
{
    /**
     * @inheritDoc
     */
    function getType(): string
    {
        return self::INT;
    }

    /**
     * @inheritDoc
     */
    function isValid(mixed $value): bool
    {
        return is_int($value);
    }
}