<?php

namespace Feral\Core\Process\Persistence\Entity\V1;
/**
 * A persist-able node
 */
class Node
{
    /**
     * The unique key in the process that identifies this node.
     * @var string
     */
    private string $key;
    /**
     * A human description that describes the node purpose.
     * @var string
     */
    private string $description;
    /**
     * The key of the catalog node to use
     * @var string
     */
    private string $catalogNodeKey;
    /**
     * A simple key / value
     * @var array
     */
    private array $configuration = [];
    /**
     * A simple key (result) / value (next node)
     * @var array[]
     */
    private array $edges = [];

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return Node
     */
    public function setKey(string $key): Node
    {
        $this->key = $key;
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
     * @return Node
     */
    public function setDescription(string $description): Node
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getCatalogNodeKey(): string
    {
        return $this->catalogNodeKey;
    }

    /**
     * @param string $catalogNodeKey
     * @return Node
     */
    public function setCatalogNodeKey(string $catalogNodeKey): Node
    {
        $this->catalogNodeKey = $catalogNodeKey;
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
     * @return Node
     */
    public function setConfiguration(array $configuration): Node
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * Add a configuration key and value to the node
     * @param string $key
     * @param string|int|float $value
     * @return Node
     */
    public function addConfiguration(string $key, string|int|float $value): Node
    {
        $this->configuration[$key] = $value;
        return $this;
    }

    /**
     * @return array[]
     */
    public function getEdges(): array
    {
        return $this->edges;
    }

    /**
     * @param array[] $edges
     * @return Node
     */
    public function setEdges(array $edges): Node
    {
        $this->edges = $edges;
        return $this;
    }

    public function addEdge(string $result, string $key): Node
    {
        $this->edges[$result] = $key;
        return $this;
    }
}