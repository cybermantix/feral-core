<?php

namespace NoLoCo\Core\Process\Node;

/**
 * A concrete implementation of the process node.
 *
 * @see NodeInterface
 */
class Node implements NodeInterface
{
    /**
     * The unique key in the process for this node
     *
     * @var string
     */
    private string $key;
    /**
     * The human description that describes this node.
     *
     * @var string
     */
    private string $description = '';
    /**
     * The catalog node key this node uses.
     *
     * @var string
     */
    private string $catalogNodeKey;
    /**
     * The configuration key/value pairs.
     *
     * @var array
     */
    private array $configuration = [];

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param  string $key
     * @return Node
     */
    public function setKey(string $key): Node
    {
        $this->key = $key;
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
     * @return Node
     */
    public function setDescription(string $description): Node
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getCatalogNodeKey(): string
    {
        return $this->catalogNodeKey;
    }

    /**
     * @param  string $catalogNodeKey
     * @return Node
     */
    public function setCatalogNodeKey(string $catalogNodeKey): Node
    {
        $this->catalogNodeKey = $catalogNodeKey;
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
     * @return Node
     */
    public function setConfiguration(array $configuration): Node
    {
        $this->configuration = $configuration;
        return $this;
    }
}
