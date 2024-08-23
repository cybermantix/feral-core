<?php

namespace Feral\Core\Process\Attributes;

/**
 * Use this configuration description for configuration values that are
 * a string.
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class FloatConfigurationDescription extends AbstractConfigurationDescription
{
    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return self::FLOAT;
    }

    /**
     * @inheritDoc
     */
    public function isValid(mixed $value): bool
    {
        return is_float($value);
    }
}
