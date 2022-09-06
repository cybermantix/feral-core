<?php

namespace NoLoCo\Core\Process\NodeCode\Configuration\Description;

/**
 * Use this configuration description for configuration values that are
 * a string.
 */
class StringConfigurationDescription extends AbstractConfigurationDescription
{
    /**
     * @inheritDoc
     */
    function getType(): string
    {
        return self::STRING;
    }

    /**
     * @inheritDoc
     */
    function isValid(mixed $value): bool
    {
        return 0 < strlen((string)$value);
    }
}