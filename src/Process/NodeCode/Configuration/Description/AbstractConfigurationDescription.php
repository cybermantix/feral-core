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

    function setOptions(array $options): static
    {
        $this->options = $options;
        return $this;
    }

    function getOptions(): array
    {
        return $this->options;
    }
}