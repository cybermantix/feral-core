<?php

namespace NoLoCo\Core\Process\NodeCode\Configuration\Description;

/**
 * Use this configuration description for configuration values that are
 * an array of strings
 */
class FloatArrayConfigurationDescription extends AbstractConfigurationDescription implements OptionsDescriptionInterface
{
    public function __construct(
        protected array $validOptions = []
    ){}

    /**
     * @inheritDoc
     */
    function getType(): string
    {
        return self::FLOAT_ARRAY;
    }

    /**
     * @inheritDoc
     */
    function isValid(mixed $value): bool
    {
        if (empty($this->validOptions)) {
            return is_array($value);
        } else {
            return is_array($value) && 0 == count(array_diff($value, $this->validOptions));
        }
    }

    /**
     * @inheritDoc
     */
    function getOptions(): array
    {
        return $this->validOptions;
    }
}