<?php

namespace Feral\Core\Process\Attributes;

/**
 * A decorator used to created Catalog nodes from node code classes
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class CatalogNodeDecorator
{
    public function __construct(
        private string $key,
        private string $name,
        private string $group,
        private string $description,
        private array $configuration = [],
    ){}

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return CatalogNodeDecorator
     */
    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return CatalogNodeDecorator
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }



    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param string $group
     * @return CatalogNodeDecorator
     */
    public function setGroup(string $group): self
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return CatalogNodeDecorator
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return array
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * @param array $configuration
     * @return CatalogNodeDecorator
     */
    public function setConfiguration(array $configuration): self
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * @param array $configurationDescriptions
     * @return CatalogNodeDecorator
     */
    public function setConfigurationDescriptions(array $configurationDescriptions): self
    {
        $this->configurationDescriptions = $configurationDescriptions;
        return $this;
    }
}