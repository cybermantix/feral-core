<?php

namespace Feral\Core\Process\Attributes;

/**
 * Use this configuration description for configuration values that are
 * a string.
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class ContextConfigurationDescription extends AbstractConfigurationDescription
{
    public function __construct(
        string $description = 'The context path to set the value.')
    {
        parent::__construct(
            key: 'output_context_path',
            name: 'Context Path',
            description: $description,
            default: 'output'
        );
    }

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
