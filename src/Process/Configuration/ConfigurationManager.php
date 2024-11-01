<?php

namespace Feral\Core\Process\Configuration;

/**
 * Override data in an array with data from another array.
 */
class ConfigurationManager
{
    const DELETE = '_DELETE_';

    /**
     * Init the configuration instance
     *
     * @var ConfigurationValueInterface[]
     */
    protected array $configuration = [];

    /**
     * Using array_merge is faster than using a loop with assignment.
     *
     * @param  ConfigurationValueInterface[] $overrides
     * @return ConfigurationManager
     */
    public function merge(array $overrides): self
    {
        foreach ($overrides as $value) {
            $key = $value->getKey();
            // DELETE
            if (isset($this->configuration[$key]) && self::DELETE === $value->getValue()) {
                unset($this->configuration[$key]);
            } else {
                $this->configuration[$key] = $value;
            }
        }
        return $this;
    }

    /**
     * Check if the configuration value is set.
     *
     * @param  string $key
     * @return bool
     */
    public function hasValue(string $key): bool
    {
        return isset($this->configuration[$key]) && $this->configuration[$key]->hasValue();
    }

    public function hasDefault(string $key): bool
    {
        return isset($this->configuration[$key]) && $this->configuration[$key]->hasDefault();
    }

    /**
     * Get a value from the configuration
     *
     * @param string $key
     * @return ConfigurationValueInterface|null
     */
    public function getValue(string $key): mixed
    {
        if ($this->hasValue($key)) {
            return $this->configuration[$key]->getValue();
        } else if ($this->hasDefault($key)) {
            return $this->configuration[$key]->getDefault();
        } else {
            return null;
        }
    }


    /**
     * Get a value from the configuration
     *
     * @param string $key
     * @return ConfigurationValueInterface|null
     */
    public function getUnmaskedValue(string $key): mixed
    {
        if ($this->hasValue($key)) {
            return $this->configuration[$key]->getUnmaskedValue();
        } else {
            return null;
        }
    }

    /**
     * A helper method to add the delete value to an array.
     *
     * @param  array  $main
     * @param  string $key
     * @return array
     */
    public function addDeleteValue(array $main, string $key): array
    {
        $main[$key] = (new ConfigurationValue())
            ->setKey($key)
            ->setValue(self::DELETE);
        return $main;
    }

    /**
     * Get the configuration
     *
     * @return ConfigurationValueInterface[]
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }
}
