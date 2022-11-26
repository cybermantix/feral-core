<?php

namespace NoLoCo\Core\Process\Catalog\CatalogNode;

use NoLoCo\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;

/**
 * A Catalog Node implementation that carries the information
 * needed to produce product nodes.
 */
class CatalogNode implements CatalogNodeInterface
{
    /**
     * The unique key for this catalog node.
     *
     * @var string
     */
    private string $key = '';
    /**
     * The node code key used for the programatic
     * functionality.
     *
     * @var string
     */
    private string $nodeCodeKey = '';
    /**
     * The human friendly name for this catalog node
     *
     * @var string
     */
    private string $name = '';
    /**
     * The group or collection this catalog node belongs to.
     *
     * @var string
     */
    private string $group = CatalogNodeInterface::DEFAULT_GROUP;
    /**
     * The human friendly description for this catalog node
     *
     * @var string
     */
    private string $description = '';
    /**
     * The configuration options for this catalog node
     *
     * @var array
     */
    private array $configuration = [];
    /**
     *
     * @var ConfigurationDescriptionInterface[]
     */
    private array $configurationDescriptions = [];

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param  string $key
     * @return CatalogNode
     */
    public function setKey(string $key): CatalogNode
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodeKey(): string
    {
        return $this->nodeCodeKey;
    }

    /**
     * @param  string $nodeCodeKey
     * @return CatalogNode
     */
    public function setNodeCodeKey(string $nodeCodeKey): CatalogNode
    {
        $this->nodeCodeKey = $nodeCodeKey;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param  string $name
     * @return CatalogNode
     */
    public function setName(string $name): CatalogNode
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @param  string $group
     * @return CatalogNode
     */
    public function setGroup(string $group): CatalogNode
    {
        $this->group = $group;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param  string $description
     * @return CatalogNode
     */
    public function setDescription(string $description): CatalogNode
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    /**
     * @param  array $configuration
     * @return CatalogNode
     */
    public function setConfiguration(array $configuration): CatalogNode
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getConfigurationDescriptions(): array
    {
        return $this->configurationDescriptions;
    }

    /**
     * @param  ConfigurationDescriptionInterface[] $configurationDescriptions
     * @return CatalogNode
     */
    public function setConfigurationDescriptions(array $configurationDescriptions): CatalogNode
    {
        $this->configurationDescriptions = $configurationDescriptions;
        return $this;
    }
}
