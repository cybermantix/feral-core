<?php

namespace NoLoCo\Core\Process\NodeCode\Traits;

use NoLoCo\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;

/**
 * Add the instance vars and getters for the interface which
 * help name, categorize, and tag the node code.
 */
trait NodeCodeMetaTrait
{
    /**
     * The key used to identify this node and used to identify
     * the relationship in the graph edges
     *
     * @var string
     */
    protected string $key;
    /**
     * The human friendly name of the node code.
     *
     * @var string
     */
    protected string $name;
    /**
     * The human friendly description of the node code.
     *
     * @var string
     */
    protected string $description;
    /**
     * The category this node code belongs to.
     *
     * @var string
     */
    protected string $categoryKey;

    /**
     * @see NodeCodeInterface::getKey()
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @see NodeCodeInterface::getName()
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @see NodeCodeInterface::getDescription()
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @see NodeCodeInterface::getCategoryKey()
     */
    public function getCategoryKey(): string
    {
        return $this->categoryKey;
    }

    /**
     * Set the local meta properties
     *
     * @param  string $key
     * @param  string $name
     * @param  string $description
     * @param  string $categoryKey
     * @return $this
     */
    protected function setMeta(string $key, string $name, string $description, string $categoryKey): static
    {
        $this->key = $key;
        $this->name = $name;
        $this->description = $description;
        $this->categoryKey = $categoryKey;
        return $this;
    }
}
