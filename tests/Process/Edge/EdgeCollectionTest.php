<?php

namespace Tests\Unit\Process\Edge;

use NoLoCo\Core\Process\Edge\Edge;
use NoLoCo\Core\Process\Edge\EdgeCollection;
use PHPUnit\Framework\TestCase;

class EdgeCollectionTest extends TestCase
{

    public function testGetEdgesByNodeAndResult()
    {
        $collection = new EdgeCollection();
        $collection
            ->addEdge(
                (new Edge())
                    ->setFromKey('from')
                    ->setToKey('to')
                    ->setResult('test'))
            ->addEdge(
                (new Edge())
                    ->setFromKey('from')
                    ->setToKey('second')
                    ->setResult('test'))
            ->addEdge(
                (new Edge())
                    ->setFromKey('one')
                    ->setToKey('two')
                    ->setResult('true')
            );

        $this->assertCount(2, $collection->getEdgesByNodeAndResult('from', 'test'));
    }

    public function testGetToKeysByNodeAndResult()
    {
        $collection = new EdgeCollection();
        $collection
            ->addEdge((new Edge())
                ->setFromKey('from')
                ->setToKey('to')
                ->setResult('test')
            )->addEdge(
                (new Edge())
                    ->setFromKey('one')
                    ->setToKey('two')
                    ->setResult('true')
            );

        $this->assertEquals(['to'], $collection->getToKeysByNodeAndResult('from', 'test'));
    }

    public function testRemoveEdge()
    {
        $test = (new Edge())
            ->setFromKey('from')
            ->setToKey('to')
            ->setResult('test');
        $collection = new EdgeCollection();
        $collection
            ->addEdge($test)
            ->addEdge(
                (new Edge())
                    ->setFromKey('one')
                    ->setToKey('two')
                    ->setResult('true')
            )->removeEdge($test);

        $this->assertCount(1, $collection->getEdges());
    }

    public function testRemoveEdgesToNode()
    {
        $test = (new Edge())
            ->setFromKey('from')
            ->setToKey('to')
            ->setResult('test');
        $collection = new EdgeCollection();
        $collection
            ->addEdge($test)
            ->addEdge(
                (new Edge())
                    ->setFromKey('one')
                    ->setToKey('two')
                    ->setResult('true'))
            ->removeEdgesToNode('to');

        $this->assertCount(1, $collection->getEdges());
    }

    public function testAddEdge()
    {
        $collection = new EdgeCollection();
        $collection
            ->addEdge((new Edge())
                ->setFromKey('from')
                ->setToKey('to')
                ->setResult('test')
            )->addEdge(
                (new Edge())
                    ->setFromKey('one')
                    ->setToKey('two')
                    ->setResult('true')
            );

        $this->assertCount(2, $collection->getEdges());
    }

    public function testRemoveEdgesFromNode()
    {
        $test = (new Edge())
            ->setFromKey('from')
            ->setToKey('to')
            ->setResult('test');
        $collection = new EdgeCollection();
        $collection
            ->addEdge($test)
            ->addEdge(
                (new Edge())
                    ->setFromKey('one')
                    ->setToKey('two')
                    ->setResult('true'))
            ->removeEdgesFromNode('one');
        $this->assertCount(1, $collection->getEdges());
    }
}
