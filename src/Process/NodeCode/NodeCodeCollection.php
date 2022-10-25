<?php

namespace NoLoCo\Core\Process\NodeCode;

use NoLoCo\Core\Process\Exception\InvalidNodeCodeKey;

/**
 * Store a collection of node codes and access by key.
 */
class NodeCodeCollection
{
    /**
     * @var NodeCodeInterface[]
     */
    private array $nodeCodes = [];

    public function addNodeCode(NodeCodeInterface $nodeCode): self
    {
        $this->nodeCodes[$nodeCode->getKey()] = $nodeCode;
        return $this;
    }

    /**
     * @param NodeCodeInterface[] $nodeCodes
     * @return $this
     */
    public function addNodeCodeArray(array $nodeCodes): self
    {
        foreach ($nodeCodes as $nodeCode) {
            $this->addNodeCode($nodeCode);
        }
        return $this;
    }

    /**
     * @throws InvalidNodeCodeKey
     */
    public function getNodeCodeByKey(string $key): NodeCodeInterface
    {
        if (isset($this->nodeCodes[$key])) {
            return $this->nodeCodes[$key];
        } else {
            throw new InvalidNodeCodeKey($key);
        }
    }
}