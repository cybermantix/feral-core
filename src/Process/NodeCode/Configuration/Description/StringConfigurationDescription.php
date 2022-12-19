<?php

namespace Feral\Core\Process\NodeCode\Configuration\Description;

/**
 * Use this configuration description for configuration values that are
 * a string.
 */
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
