<?php


namespace NoLoCo\Core\Process\Edge;

/**
 * A collection of edges held in a 3D array.
 * Class EdgeCollection
 * @package App\Utility\Process\Edge
 */
class EdgeCollection implements EdgeCollectionInterface
{
    /**
     * The internal storage of edges
     * [from node key][result] => [to node keys]
     * @var array
     */
    protected array $collection = [];

    /**
     * @inheritDoc
     */
    public function addEdge(EdgeInterface $edge): EdgeCollectionInterface
    {
        $fromKey = $edge->getFromNodeKey();
        $response = $edge->getResponse();
        if (empty($this->collection[$fromKey])) {
            $this->collection[$fromKey] = [];
        }
        if (empty($this->collection[$fromKey][$response])) {
            $this->collection[$fromKey][$response] = [];
        }
        $this->collection[$fromKey][$response][] = $edge;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeEdge(EdgeInterface $edge): EdgeCollectionInterface
    {
        $fromKey = $edge->getFromNodeKey();
        $response = $edge->getResponse();
        if (!empty($this->collection[$fromKey][$response])) {
            /** @var EdgeInterface $item */
            foreach ($this->collection[$fromKey][$response] as $key => $item) {
                if ($item->getToNodeKey() == $edge->getToNodeKey()) {
                    unset($this->collection[$fromKey][$response][$key]);
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
            /** @var EdgeInterface $item */
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
             * @var string $response
             * @var array $edges
             */
            foreach ($item as $response => $edges) {
                /**
                 * @var int $idx
                 * @var EdgeInterface $edge
                 */
                foreach ($edges as $idx => $edge)
                if ($edge->getToNodeKey() == $toNodeKey) {
                    unset($this->collection[$fromNodeKey][$response][$idx]);
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
            foreach ($v as $kk => $vv) {
                foreach ($vv as $kkk => $vvv) {
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
    public function getToNodeKeysByNodeAndResult(string $fromNodeKey, string $result): array
    {
        $keys = [];
        if (!empty($this->collection[$fromNodeKey]) && !empty($this->collection[$fromNodeKey][$result])) {
            /** @var EdgeInterface $edge */
            foreach( $this->collection[$fromNodeKey][$result] as $edge) {
                $keys[] = $edge->getToNodeKey();
            }
            return $keys;
        } else {
            return [];
        }
    }
}
