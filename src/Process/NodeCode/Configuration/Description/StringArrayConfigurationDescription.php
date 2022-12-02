<?php

namespace NoLoCo\Core\Process\NodeCode\Configuration\Description;

/**
 * Use this configuration description for configuration values that are
 * an array of strings
 */
class StringArrayConfigurationDescription extends AbstractConfigurationDescription
{
    public function __construct(
        protected array $validOptions = []
    ) {
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
