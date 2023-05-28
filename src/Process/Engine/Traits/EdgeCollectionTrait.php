<?php

namespace Feral\Core\Process\Engine\Traits;

use Feral\Core\Process\Edge\Edge;
use Feral\Core\Process\Edge\EdgeCollection;
use Feral\Core\Process\Edge\EdgeInterface;
use Feral\Core\Process\Exception\ProcessException;

trait EdgeCollectionTrait
{
    /**
     * @var EdgeCollection
     */
    private EdgeCollection $edgeCollection;

    /**
     * Add an array of edges
     *
     * @param  EdgeInterface[] $edges
     * @return $this
     */
    protected function addEdgeCollection(array $edges): static
    {
        foreach ($edges as $edge) {
            $this->addEdge($edge);
        }
        return $this;
    }

    /**
     * Add an edge to the collection
     *
     * @param  EdgeInterface $edge
     * @return $this
     */
    protected function addEdge(EdgeInterface $edge): static
    {
        $this->edgeCollection->addEdge($edge);
        return $this;
    }


    /**
     *
     * @param string $fromNodeKey
     * @param string $result
     * @return Edge
     * @throws ProcessException
     */
    protected function getEdgeByNodeAndResult(string $fromNodeKey, string $result): Edge
    {
        $edges = $this->edgeCollection->getEdgesByNodeAndResult($fromNodeKey, $result);
        if (empty($edges)) {
            throw new ProcessException(
                sprintf('No edges found with from node "%s" with result "%s"', $fromNodeKey, $result)
            );
        }
        return array_shift($edges);
    }
}
