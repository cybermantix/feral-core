<?php

namespace NoLoCo\Core\Tests\Process;

use NoLoCo\Core\Process\ProcessJsonHydrator;
use PHPUnit\Framework\TestCase;

class ProcessJsonHydratorTest extends TestCase
{
    public function testHydrate()
    {
        $hydrator = new ProcessJsonHydrator();
        $json = <<<'EOD'
            {
              "schema_version": 1,
              "key": "test_process",
              "version": 1,
              "context": {
                "one": 1
              },
              "nodes": [
                {
                  "key": "start",
                  "description": "The starting node",
                  "catalog_node_key": "start",
                  "configuration": {},
                  "edges": {
                      "ok": "test"
                  }
                },
                {
                  "key": "test",
                  "description": "Check if the value is greater than zero",
                  "catalog_node_key": "is_greater_than_zero",
                  "configuration": {
                    "context_path": "test"
                  },
                  "edges": {
                      "true": "print",
                      "false": "stop"
                  }
                }
              ]
            }
        EOD;
        $process = $hydrator->hydrate($json);
        $this->assertCount(2, $process->getNodes());
        $this->assertCount(3, $process->getEdges());
        $this->assertEquals(1, $process->getContext()->get('one'));
        $this->assertEquals('start', $process->getNodes()[0]->getKey());
    }
}
