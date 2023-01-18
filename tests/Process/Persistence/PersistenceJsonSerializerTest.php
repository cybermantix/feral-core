<?php

namespace Feral\Core\Tests\Process\Persistence;

use Feral\Core\Process\Persistence\V1\PersistenceJsonSerializer;
use Feral\Core\Process\Persistence\V1\Entity\Node;
use Feral\Core\Process\Persistence\V1\Entity\Process;
use PHPUnit\Framework\TestCase;

class PersistenceJsonSerializerTest extends TestCase
{
    private PersistenceJsonSerializer $serializer;
    protected function setUp(): void
    {
        $this->serializer = new PersistenceJsonSerializer();
    }
    public function testSerialize()
    {
        $process = (new Process())
            ->setKey('test')
            ->setVersion(1)
            ->setContext([
                'test' => 'testing',
                'one' => 1
            ])
            ->setNodes([
                (new Node())
                    ->setKey('test1')
                    ->setCatalogNodeKey('test')
                    ->setDescription('just testing')
                    ->setConfiguration([
                        'one' => 1
                    ])
                    ->setEdges([
                        'ok' => 'test2'
                    ]),
                (new Node())
                    ->setKey('test2')
                    ->setCatalogNodeKey('testing')
                    ->setDescription('just another test')
                    ->setConfiguration([
                        'two' => 2
                    ])
                    ->setEdges([
                        'stop' => 'stop'
                    ])
            ]);
        $json = $this->serializer->serialize($process);
        $this->assertStringContainsString('"key":"test"', $json);
    }
}
