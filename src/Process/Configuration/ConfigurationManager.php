<?php

namespace NoLoCo\Core\Process\Configuration;

/**
 * Override data in an array with data from another array.
 */
class ConfigurationManager
{
    const DELETE = '_DELETE_';

    /**
     * Init the configuration instance
     *
     * @var array
     */
    protected array $configuration = [];

    /**
     * Using array_merge is faster than using a loop with assignment.
     *
     * @param  array $overrides
     * @return ConfigurationManager
     */
    public function merge(array $overrides): self
    {
        $this->configuration = array_merge($this->configuration, $overrides);
        foreach ($overrides as $key => $value) {
            // DELETE
            if (isset($this->configuration[$key]) && self::DELETE === $value) {
                unset($this->configuration[$key]);
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
        return isset($this->configuration[$key]);
    }

    /**
     * Get a value from the configuration
     *
     * @param  string $key
     * @return mixed
     */
    public function getValue(string $key): mixed
    {
        if ($this->hasValue($key)) {
            return $this->configuration[$key];
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
        $main[$key] = self::DELETE;
        return $main;
    }

    /**
     * Get the configuration
     *
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }
}
