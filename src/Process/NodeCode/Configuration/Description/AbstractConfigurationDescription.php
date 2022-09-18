<?php

namespace NoLoCo\Core\Process\NodeCode\Configuration\Description;

/**
 * Use this configuration description for configuration values that are
 * a string.
 */
abstract class AbstractConfigurationDescription implements ConfigurationDescriptionInterface, OptionsDescriptionInterface
{
    /**
     * The configuration key.
     * @var string
     */
    protected string $key;

    /**
     * The human friendly name of this configuration description
     * @var string
     */
    protected string $name;

    /**
     * The human friendly description
     * @var string
     */
    protected string $description;

    /**
     * Possible options for this value
     * @var array
     */
    protected array $options = [];

    /**
     * Set the configuration key which is used to identify the configuration.
     * @param string $key
     * @return $this
     */
    function setKey(string $key): static
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getKey(): string
    {
        return $this->key;
    }

    /**
     * Set the human friendly name of the configurations
     * @param string $name
     * @return $this
     */
    function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the human description of this configuration option.
     * @param string $description
     * @return $this
     */
    function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the optional options allowed for the configuration.
     * @param array $options
     * @return $this
     */
    function setOptions(array $options): static
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @inheritDoc
     */
    function getOptions(): array
    {
        return $this->options;
    }
}