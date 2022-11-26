<?php

namespace NoLoCo\Core\Process\Edge;

/**
 * A collection of edges with helper functions to manipulate the collection.
 * Interface EdgeCollectionInterface
 *
 * @package App\Utility\Process\Edge
 */
interface EdgeCollectionInterface
{
    /**
     * Add an edge to this collection
     *
     * @param  EdgeInterface $edge
     * @return EdgeCollectionInterface
     */
    public function addEdge(EdgeInterface $edge): EdgeCollectionInterface;

    /**
     * Remove an edge from this collection
     *
     * @param  EdgeInterface $edge
     * @return EdgeCollectionInterface
     */
    public function removeEdge(EdgeInterface $edge): EdgeCollectionInterface;

    /**
     * Remove all edges tied to the from node.
     *
     * @param  string $fromNodeKey
     * @return EdgeCollectionInterface
     */
    public function removeEdgesFromNode(string $fromNodeKey): EdgeCollectionInterface;

    /**
     * Remove all nodes tied to a to node.
     *
     * @param  string $toNodeKey
     * @return EdgeCollectionInterface
     */
    public function removeEdgesToNode(string $toNodeKey): EdgeCollectionInterface;

    /**
     * Get all of the edges stored in the collection.
     *
     * @return array
     */
    public function getEdges(): array;

    /**
     * Get all of the edges using the from node key and the result from that node.
     *
     * @param  string $fromNodeKey
     * @param  string $result
     * @return array
     */
    public function getEdgesByNodeAndResult(string $fromNodeKey, string $result): array;

    /**
     * Get an array of node keys based on the from node key and result.
     *
     * @param  string $fromNodeKey
     * @param  string $result
     * @return EdgeInterface[]
     */
    public function getToKeysByNodeAndResult(string $fromNodeKey, string $result): array;
}
