<?php

namespace Feral\Core\Process\Edge;

/**
 * @see EdgeInterface
 */
class Edge implements EdgeInterface
{
    /**
     * The node key from the source side of the node.
     *
     * @var string
     */
    protected string $fromKey;
    /**
     * The node key for the next node.
     *
     * @var string
     */
    protected string $toKey;
    /**
     * The result to select this edge.
     *
     * @var string
     */
    protected string $result;

    /**
     * @return string
     */
    public function getFromKey(): string
    {
        return $this->fromKey;
    }

    /**
     * @param string $fromKey
     */
    public function setFromKey(string $fromKey): static
    {
        $this->fromKey = $fromKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getToKey(): string
    {
        return $this->toKey;
    }

    /**
     * @param string $toKey
     */
    public function setToKey(string $toKey): static
    {
        $this->toKey = $toKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * @param string $result
     */
    public function setResult(string $result): static
    {
        $this->result = $result;
        return $this;
    }
}
