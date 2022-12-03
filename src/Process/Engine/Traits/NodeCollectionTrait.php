<?php

namespace Nodez\Core\Process\Engine\Traits;

use Nodez\Core\Process\Exception\InvalidNodeKey;
use Nodez\Core\Process\Node\NodeCollection;
use Nodez\Core\Process\Node\NodeInterface;

/**
 * Store nodes and make them accessible by key
 */
trait NodeCollectionTrait
{
    /**
     * @var NodeCollection
     */
    private NodeCollection $nodeCollection;

    /**
     * Add an array of edges
     *
     * @param  NodeInterface[] $collection
     * @return $this
     */
    protected function addNodeCollection(array $collection): static
    {
        foreach ($collection as $node) {
            $this->addNode($node);
        }
        return $this;
    }

    /**
     * Add a node to the collection
     *
     * @param  NodeInterface $node
     * @return $this
     */
    protected function addNode(NodeInterface $node): static
    {
        $this->nodeCollection->addNode($node);
        return $this;
    }

    /**
     * @param  string $fromNodeKey
     * @return NodeInterface
     * @throws InvalidNodeKey
     */
    protected function getNodeCodeByKey(string $fromNodeKey): NodeInterface
    {
        return $this->nodeCollection->getNodeByKey($fromNodeKey);
    }
}
