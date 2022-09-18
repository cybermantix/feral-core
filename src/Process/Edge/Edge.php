<?php

namespace NoLoCo\Core\Process\Edge;

class Edge implements EdgeInterface
{
    protected string $fromKey;

    protected string $toKey;

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

}