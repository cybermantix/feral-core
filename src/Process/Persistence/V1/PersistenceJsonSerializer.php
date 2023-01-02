<?php

namespace Feral\Core\Process\Persistence\V1;

use Exception;
use Feral\Core\Process\Persistence\V1\Entity\Process;

/**
 * Hydrate a json string into a process object
 */
class PersistenceJsonSerializer
{
    /**
     * @throws Exception
     */
    public function serialize(Process $process): string
    {
        $obj = new \stdClass();
        $obj->schema_version = 1;
        $obj->key = $process->getKey();
        $obj->version = $process->getVersion();
        $obj->context = [];
        foreach ($process->getContext() as $key => $value) {
            $obj->context[$key] = $value;
        }
        $obj->nodes = [];
        foreach ($process->getNodes() as $node) {
            $temp = new \stdClass();
            $temp->key = $node->getKey();
            $temp->catalog_key_node = $node->getCatalogNodeKey();
            $temp->description = $node->getDescription();
            $temp->configuration = $node->getConfiguration();
            $temp->edges = $node->getEdges();
            $obj->nodes[] = $temp;
        }
        return json_encode($obj);
    }
}
