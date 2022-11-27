<?php

namespace NoLoCo\Core\Process\Engine\Traits;

use NoLoCo\Core\Process\Exception\InvalidNodeCodeKey;
use NoLoCo\Core\Process\NodeCode\NodeCodeCollection;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;

/**
 * Store nodes and make them accessible by key
 */
trait NodeCodeCollectionTrait
{
    /**
     * @var NodeCodeCollection
     */
    private NodeCodeCollection $nodeCodeCollection;

    /**
     * Add an array of edges
     *
     * @param  NodeCodeInterface[] $collection
     * @return $this
     */
    protected function addNodeCodeCollection(array $collection): static
    {
        foreach ($collection as $nodeCode) {
            $this->addNodeCode($nodeCode);
        }
        return $this;
    }

    /**
     * Add a node to the collection
     *
     * @param  NodeCodeInterface $node
     * @return $this
     */
    protected function addNodeCode(NodeCodeInterface $node): static
    {
        $this->nodeCodeCollection->addNodeCode($node);
        return $this;
    }

    /**
     * @param  string $fromNodeKey
     * @return NodeCodeInterface
     * @throws InvalidNodeCodeKey
     */
    protected function getNodeCodeByKey(string $fromNodeKey): NodeCodeInterface
    {

        return $this->nodeCodeCollection->getNodeCodeByKey($fromNodeKey);
    }
}
