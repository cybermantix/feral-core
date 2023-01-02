<?php

namespace Feral\Core\Process\Persistence\V1;

use Exception;
use Feral\Core\Process\Persistence\V1\Entity\Node;
use Feral\Core\Process\Persistence\V1\Entity\Process;

/**
 * Hydrate a json string into a process object
 */
class PersistenceJsonHydrator
{
    /**
     * @throws Exception
     */
    public function hydrate(string $jsonString): Process
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

        $process = (new Process())
            ->setKey($key);

        // VERSION
        if (isset($json['version'])) {
            $process->setVersion($json['version']);
        } else {
            $process->setVersion(1);
        }

        // CONTEXT
        if (isset($json['context'])) {
            foreach ($json['context'] as $key => $value) {
                $process->addContextValue($key, $value);
            }
        }

        // NODES
        foreach ($json['nodes'] as $node) {
            $process->addNode($this->hydrateNode($node));
        }

        return $process;
    }

    /**
     * Create a node from the array data.
     *
     * @param  array $data
     * @return NodeInterfac
     */
    protected function hydrateNode(array $data): Node
    {
        $node = new Node();
        $node
            ->setKey($data['key'])
            ->setCatalogNodeKey($data['catalog_node_key']);
        if (isset($data['description'])) {
            $node->setDescription($data['description']);
        }
        if (isset($data['configuration'])) {
            foreach ($data['configuration'] as $key => $value) {
                $node->addConfiguration($key, $value);
            }
        }
        if (isset($data['edges'])) {
            foreach ($data['edges'] as $result => $key) {
                $node->addEdge($result, $key);
            }
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
}
