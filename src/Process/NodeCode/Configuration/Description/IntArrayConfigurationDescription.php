<?php

namespace Feral\Core\Process\NodeCode\Configuration\Description;

/**
 * Use this configuration description for configuration values that are
 * an array of ints.
 */
class IntArrayConfigurationDescription extends AbstractConfigurationDescription implements OptionsDescriptionInterface
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
        return self::INT_ARRAY;
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

    /**
     * @inheritDoc
     */
    public function getOptions(): array
    {
        return $this->validOptions;
    }
}
