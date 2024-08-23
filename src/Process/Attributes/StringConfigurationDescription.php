<?php

namespace Feral\Core\Process\Attributes;

/**
 * Use this configuration description for configuration values that are
 * a string.
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class StringConfigurationDescription extends AbstractConfigurationDescription
{
    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return self::STRING;
    }

    /**
     * @inheritDoc
     */
    public function isValid(mixed $value): bool
    {
        return 0 < strlen((string)$value);
    }
}
