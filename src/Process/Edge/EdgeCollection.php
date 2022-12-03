<?php

namespace Nodez\Core\Process\Edge;

/**
 * A collection of edges held in a 3D array.
 * Class EdgeCollection
 *
 * @package App\Utility\Process\Edge
 */
class EdgeCollection implements EdgeCollectionInterface
{
    /**
     * The internal storage of edges
     * [from node key][result] => [to node keys]
     *
     * @var array
     */
    protected array $collection = [];

    /**
     * @inheritDoc
     */
    public function addEdge(EdgeInterface $edge): EdgeCollectionInterface
    {
        $fromKey = $edge->getFromKey();
        $result = $edge->getResult();

        if (empty($this->collection[$fromKey])) {
            $this->collection[$fromKey] = [];
        }
        if (empty($this->collection[$fromKey][$result])) {
            $this->collection[$fromKey][$result] = [];
        }
        $this->collection[$fromKey][$result][] = $edge;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeEdge(EdgeInterface $edge): EdgeCollectionInterface
    {
        $fromKey = $edge->getFromKey();
        $result = $edge->getResult();
        if (!empty($this->collection[$fromKey][$result])) {
            /**
 * @var EdgeInterface $item
*/
            foreach ($this->collection[$fromKey][$result] as $key => $item) {
                if ($item->getToKey() == $edge->getToKey()) {
                    unset($this->collection[$fromKey][$result][$key]);
                }
            }
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeEdgesFromNode(string $fromNodeKey): EdgeCollectionInterface
    {
        if (!empty($this->collection[$fromNodeKey])) {
            /**
 * @var EdgeInterface $item
*/
            foreach ($this->collection[$fromNodeKey] as $key => $item) {
                unset($this->collection[$fromNodeKey][$key]);
            }
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeEdgesToNode(string $toNodeKey): EdgeCollectionInterface
    {
        foreach ($this->collection as $fromNodeKey => $item) {
            /**
             * @var string $result
             * @var array $edges
             */
            foreach ($item as $result => $edges) {
                /**
                 * @var int $idx
                 * @var EdgeInterface $edge
                 */
                foreach ($edges as $idx => $edge) {
                    if ($edge->getToKey() == $toNodeKey) {
                        unset($this->collection[$fromNodeKey][$result][$idx]);
                    }
                }
            }
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getEdges(): array
    {
        $edges = [];
        foreach ($this->collection as $k => $v) {
            foreach ($v as $vv) {
                foreach ($vv as $vvv) {
                    $edges[] = $vvv;
                }
            }
        }
        return $edges;
    }


    /**
     * @inheritDoc
     */
    public function getEdgesByNodeAndResult(string $fromNodeKey, string $result): array
    {
        if (!empty($this->collection[$fromNodeKey]) && !empty($this->collection[$fromNodeKey][$result])) {
            return $this->collection[$fromNodeKey][$result];
        } else {
            return [];
        }
    }

    /**
     * @inheritDoc
     */
    public function getToKeysByNodeAndResult(string $fromNodeKey, string $result): array
    {
        $keys = [];
        if (!empty($this->collection[$fromNodeKey]) && !empty($this->collection[$fromNodeKey][$result])) {
            /**
 * @var EdgeInterface $edge
*/
            foreach ($this->collection[$fromNodeKey][$result] as $edge) {
                $keys[] = $edge->getToKey();
            }
            return $keys;
        } else {
            return [];
        }
    }
}
