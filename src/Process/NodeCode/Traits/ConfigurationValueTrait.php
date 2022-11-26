<?php

namespace NoLoCo\Core\Process\NodeCode\Traits;

use NoLoCo\Core\Process\Exception\MissingConfigurationValueException;

/**
 * Add the methods used to get the configuration values
 * using typed return values.
 */
trait ConfigurationValueTrait
{
    /**
     * Check if a configuration value is set for a key.
     *
     * @param  string $key
     * @return bool
     */
    protected function hasConfigurationValue(string $key): bool
    {
        return $this->manager->hasValue($key);
    }

    /**
     * A helper function to get the value of a configuration key
     *
     * @param  string $key
     * @param  null   $default
     * @return mixed
     */
    protected function getConfigurationValue(string $key, $default = null): mixed
    {
        if ($this->hasConfigurationValue($key)) {
            return $this->manager->getValue($key);
        } elseif (!is_null($default)) {
            return $default;
        } else {
            return null;
        }
    }

    /**
     * A helper function to get the value of a configuration key
     *
     * @param  string $key
     * @param  null   $default
     * @return mixed
     * @throws MissingConfigurationValueException
     */
    protected function getRequiredConfigurationValue(string $key, $default = null): mixed
    {
        $value = $this->getConfigurationValue($key, $default);
        if (is_null($value)) {
            throw new MissingConfigurationValueException(
                sprintf(
                    'The configuration is missing the required value for "%s".',
                    $key
                )
            );
        }
        return $value;
    }

    /**
     * A helper function to get a configuration value as a boolean
     *
     * @param  string    $key
     * @param  bool|null $default
     * @return bool|null
     */
    protected function getBooleanConfigurationValue(string $key, bool $default = null): ?bool
    {
        return $this->getConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a configuration value as a string
     *
     * @param  string      $key
     * @param  string|null $default
     * @return string|null
     */
    protected function getStringConfigurationValue(string $key, string $default = null): ?string
    {
        return $this->getConfigurationValue($key, $default);
    }

    /**
     * A helper function to get an int configuration value.
     *
     * @param  string   $key
     * @param  int|null $default
     * @return int|null
     */
    protected function getIntConfigurationValue(string $key, int $default = null): ?int
    {
        return $this->getConfigurationValue($key, $default);
    }

    /**
     * A helper function to get an array configuration value.
     *
     * @param  string     $key
     * @param  array|null $default
     * @return array|null
     */
    protected function getArrayConfigurationValue(string $key, array $default = null): ?array
    {
        return $this->getConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a float configuration value
     *
     * @param  string     $key
     * @param  float|null $default
     * @return float|null
     */
    protected function getFloatConfigurationValue(string $key, float $default = null): ?float
    {
        return $this->getConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a configuration value as a boolean
     *
     * @param  string      $key
     * @param  string|null $default
     * @return bool|null
     * @throws MissingConfigurationValueException
     */
    protected function getRequiredBooleanConfigurationValue(string $key, string $default = null): ?bool
    {
        return $this->getRequiredConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a configuration value as a string
     *
     * @param  string      $key
     * @param  string|null $default
     * @return string|null
     * @throws MissingConfigurationValueException
     */
    protected function getRequiredStringConfigurationValue(string $key, string $default = null): ?string
    {
        return $this->getRequiredConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a required configuration value as an array
     *
     * @param  string      $key
     * @param  string|null $default
     * @return array|null
     * @throws MissingConfigurationValueException
     */
    protected function getRequiredArrayConfigurationValue(string $key, string $default = null): ?array
    {
        return $this->getRequiredConfigurationValue($key, $default);
    }

    /**
     * A helper function to get an int configuration value.
     *
     * @param  string   $key
     * @param  int|null $default
     * @return int|null
     * @throws MissingConfigurationValueException
     */
    protected function getRequiredIntConfigurationValue(string $key, int $default = null): ?int
    {
        return $this->getRequiredConfigurationValue($key, $default);
    }

    /**
     * A helper function to get a float configuration value
     *
     * @param  string     $key
     * @param  float|null $default
     * @return float|null
     * @throws MissingConfigurationValueException
     */
    protected function getRequiredFloatConfigurationValue(string $key, float $default = null): ?float
    {
        return $this->getRequiredConfigurationValue($key, $default);
    }
}
