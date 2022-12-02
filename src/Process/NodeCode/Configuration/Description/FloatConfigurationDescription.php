<?php

namespace NoLoCo\Core\Process\NodeCode\Configuration\Description;

/**
 * Use this configuration description for configuration values that are
 * a string.
 */
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
