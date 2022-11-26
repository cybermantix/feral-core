<?php

namespace NoLoCo\Core\Process\Node;

use NoLoCo\Core\Process\Exception\InvalidNodeKey;

/**
 * Store a collection of nodes and access by key.
 */
class NodeCollection
{
    /**
     * @var NodeInterface[]
     */
    private array $nodes = [];

    public function addNode(NodeInterface $node): self
    {
        $this->nodes[$node->getKey()] = $node;
        return $this;
    }

    /**
     * @param  NodeInterface[] $nodes
     * @return $this
     */
    public function addNodeArray(array $nodes): self
    {
        foreach ($nodes as $nodeCode) {
            $this->addNodeCode($nodeCode);
        }
        return $this;
    }

    /**
     * @throws InvalidNodeKey
     */
    public function getNodeByKey(string $key): NodeInterface
    {
        if (isset($this->nodes[$key])) {
            return $this->nodes[$key];
        } else {
            throw new InvalidNodeKey($key);
        }
    }
}
