<?php

namespace Feral\Core\Process\Persistence\V1\Entity;

class Process
{
    /**
     * @var string
     */
    private string $key;
    /**
     * @var int
     */
    private int $version;
    /**
     * @var array
     */
    private array $context;
    /**
     * @var Node[]
     */
    private array $nodes = [];

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     * @return Process
     */
    public function setKey(string $key): Process
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @param int $version
     * @return Process
     */
    public function setVersion(int $version): Process
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return array
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * @param array $context
     * @return Process
     */
    public function setContext(array $context): Process
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return Process
     */
    public function addContextValue(string $key, string $value): Process
    {
        $this->context[$key] = $value;
        return $this;
    }

    /**
     * @return Node[]
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    /**
     * @param Node[] $nodes
     * @return Process
     */
    public function setNodes(array $nodes): Process
    {
        $this->nodes = $nodes;
        return $this;
    }
    /**
     * @param Node $node
     * @return Process
     */
    public function addNode(Node $node): Process
    {
        $this->nodes[] = $node;
        return $this;
    }
}