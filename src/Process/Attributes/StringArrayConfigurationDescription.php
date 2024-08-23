<?php

namespace Feral\Core\Process\Attributes;

/**
 * Use this configuration description for configuration values that are
 * an array of strings
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class StringArrayConfigurationDescription extends AbstractConfigurationDescription
{

    public function __construct(
        string $key,
        string $name,
        string $description,
        array $options = [],
        protected array $validOptions = []
    )
    {
        parent::__construct(key: $key, name: $name, description: $description, options: $options);
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return self::STRING_ARRAY;
    }

    /**
     * @inheritDoc
     */
    public function isValid(mixed $value): bool
    {
        if (empty($this->validOptions)) {
            return is_array($value);
        } else {
            return is_array($value) && 0 == count(array_diff($value, $this->validOptions));
        }
    }
}
