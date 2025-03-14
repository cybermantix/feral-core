<?php

namespace Feral\Core\Process\Attributes;

use function is_bool;

/**
 * Use this configuration description for configuration values that are
 * a boolean variable.
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class BooleanConfigurationDescription extends AbstractConfigurationDescription
{
    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return self::BOOLEAN;
    }

    /**
     * @inheritDoc
     */
    public function isValid(mixed $value): bool
    {
        return is_bool($value);
    }
}
