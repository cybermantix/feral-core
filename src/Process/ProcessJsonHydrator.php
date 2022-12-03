<?php

namespace Nodez\Core\Process;

use Exception;
use Nodez\Core\Process\Context\Context;
use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\Edge\Edge;
use Nodez\Core\Process\Edge\EdgeInterface;
use Nodez\Core\Process\Node\Node;
use Nodez\Core\Process\Node\NodeInterface;

/**
 * Hydrate a json string into a process object
 */
class ProcessJsonHydrator
{
    /**
     * @throws Exception
     */
    public function hydrate(string $jsonString): ProcessInterface
    {
        $json = json_decode($jsonString, true);

        // VERSION CHECK
        $version = $json['schema_version'];
        if (1 !== $version) {
            throw new Exception('Only schema version 1 is accepted');
        }

        $key = $json['key'];
        if (empty($key)) {
            throw new Exception('A key is required for a process.');
        }

        // NODES AND EDGES
        $nodes = [];
        $edges = [];
        foreach ($json['nodes'] as $node) {
            $nodes[] = $this->hydrateNode($node);
            $nodeEdges = [];
            foreach ($node['edges'] as $result => $to) {
                $nodeEdges[] = $this->hydrateEdge($node['key'], $to, $result);
            }
            $edges = array_merge($edges, $nodeEdges);
        }

        // CONTEXT
        $context = $this->hydrateContext($json['context']);

        return (new Process())
            ->setKey($key)
            ->setNodes($nodes)
            ->setEdges($edges)
            ->setContext($context);
    }

    /**
     * Create a node from the array data.
     *
     * @param  array $data
     * @return NodeInterface
     */
    protected function hydrateNode(array $data): NodeInterface
    {
        $node = new Node();
        $node
            ->setKey($data['key'])
            ->setCatalogNodeKey($data['catalog_node_key']);
        if (isset($data['description'])) {
            $node->setDescription($data['description']);
        }
        if (isset($data['configuration'])) {
            $node->setConfiguration($data['configuration']);
        }
        return $node;
    }

    /**
     * Create a new edge from the parameters
     *
     * @param  string $from
     * @param  string $to
     * @param  string $result
     * @return EdgeInterface
     */
    protected function hydrateEdge(string $from, string $to, string $result): EdgeInterface
    {
        $edge = new Edge();
        $edge
            ->setFromKey($from)
            ->setToKey($to)
            ->setResult($result);
        return $edge;
    }

    /**
     * Take a plain array and hydrate a context object.
     *
     * @param  array $data
     * @return ContextInterface
     */
    protected function hydrateContext(array $data): ContextInterface
    {
        $context = new Context();
        foreach ($data as $key => $value) {
            $context->set($key, $value);
        }
        return $context;
    }
}
