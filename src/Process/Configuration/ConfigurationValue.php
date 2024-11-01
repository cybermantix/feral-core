<?php

namespace Feral\Core\Process\Configuration;

/**
 * A NodeCode or CatalogNode configuration value.
 */
class ConfigurationValue implements ConfigurationValueInterface
{
    /**
     *
     */
    const MASK = '*********';

    /**
     * @var string
     */
    protected string $key;

    /**
     * @var mixed
     */
    protected mixed $value;

    /**
     * @var mixed | null
     */
    protected mixed $default = null;


    /**
     * @var ConfigurationValueType
     */
    protected ConfigurationValueType $type;


    /**
     * Override __toString to control the string representation of the object.
     */
    public function __toString(): string
    {
        return json_encode(sprintf(
            'Configuration Value "%s" :: "%s"',
            $this->key,
            $this->getValue()
        ));
    }

    /**
     * Override __debugInfo to control the debug output of the object.
     */
    public function __debugInfo(): array
    {
        return [
            'key' => $this->key,
            'value' => $this->getValue(),
            'default' => $this->default
        ];
    }

    /**
     * @param string $key
     * @return ConfigurationValue
     */
    public function setKey(string $key): ConfigurationValue
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        $value = $this->value;
        if (!empty($value) && $this->isSecret()) {
            return self::MASK;
        } else {
            return $value;
        }
    }

    public function getDefault(): mixed
    {
        if (isset($this->default)) {
            return $this->default;
        } else {
            return null;
        }
    }

    public function hasDefault(): bool
    {
        return isset($this->default) && $this->default != null;
    }

    public function hasValue(): bool
    {
        return isset($this->value) && $this->value != null;
    }

    /**
     * @param mixed $value
     * @param ConfigurationValueType $type
     * @return ConfigurationValue
     */
    public function setValue(mixed $value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param mixed $default
     * @return ConfigurationValue
     */
    public function setDefault(mixed $default): static
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @param ConfigurationValueType $type
     * @return ConfigurationValue
     */
    public function setType(ConfigurationValueType $type): static
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed | null
     */
    public function getUnmaskedValue(): mixed
    {
        return $this->value ?? $this->default;
    }

    public function isSecret(): bool
    {
        return ConfigurationValueType::SECRET == $this->type || ConfigurationValueType::OPTIONAL_SECRET == $this->type;
    }
}