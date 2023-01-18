<?php

namespace Feral\Core\Tests\Process\Persistence;

use Feral\Core\Process\Persistence\V1\PersistenceJsonHydrator;
use PHPUnit\Framework\TestCase;

class PersistenceJsonHydratorTest extends TestCase
{
    private PersistenceJsonHydrator $hydrator;
    protected function setUp(): void
    {
        $this->hydrator = new PersistenceJsonHydrator();
    }
    public function testHydrate()
    {
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
        $process = $this->hydrator->hydrate($json);
        $this->assertCount(2, $process->getNodes());
        $this->assertCount(2, $process->getNodes()[1]->getEdges());
        $this->assertEquals(1, $process->getContext()['one']);
        $this->assertEquals('start', $process->getNodes()[0]->getKey());
    }
}
