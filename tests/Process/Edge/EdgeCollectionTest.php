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
                    ->setFromNodeKey('from')
                    ->setToNodeKey('to')
                    ->setResponse('test'))
            ->addEdge(
                (new Edge())
                    ->setFromNodeKey('from')
                    ->setToNodeKey('second')
                    ->setResponse('test'))
            ->addEdge(
                (new Edge())
                    ->setFromNodeKey('one')
                    ->setToNodeKey('two')
                    ->setResponse('true')
            );

        $this->assertCount(2, $collection->getEdgesByNodeAndResult('from', 'test'));
    }

    public function testGetToNodeKeysByNodeAndResult()
    {
        $collection = new EdgeCollection();
        $collection
            ->addEdge((new Edge())
                ->setFromNodeKey('from')
                ->setToNodeKey('to')
                ->setResponse('test')
            )->addEdge(
                (new Edge())
                    ->setFromNodeKey('one')
                    ->setToNodeKey('two')
                    ->setResponse('true')
            );

        $this->assertEquals(['to'], $collection->getToNodeKeysByNodeAndResult('from', 'test'));
    }

    public function testRemoveEdge()
    {
        $test = (new Edge())
            ->setFromNodeKey('from')
            ->setToNodeKey('to')
            ->setResponse('test');
        $collection = new EdgeCollection();
        $collection
            ->addEdge($test)
            ->addEdge(
                (new Edge())
                    ->setFromNodeKey('one')
                    ->setToNodeKey('two')
                    ->setResponse('true')
            )->removeEdge($test);

        $this->assertCount(1, $collection->getEdges());
    }

    public function testRemoveEdgesToNode()
    {
        $test = (new Edge())
            ->setFromNodeKey('from')
            ->setToNodeKey('to')
            ->setResponse('test');
        $collection = new EdgeCollection();
        $collection
            ->addEdge($test)
            ->addEdge(
                (new Edge())
                    ->setFromNodeKey('one')
                    ->setToNodeKey('two')
                    ->setResponse('true'))
            ->removeEdgesToNode('to');

        $this->assertCount(1, $collection->getEdges());
    }

    public function testAddEdge()
    {
        $collection = new EdgeCollection();
        $collection
            ->addEdge((new Edge())
                ->setFromNodeKey('from')
                ->setToNodeKey('to')
                ->setResponse('test')
            )->addEdge(
                (new Edge())
                    ->setFromNodeKey('one')
                    ->setToNodeKey('two')
                    ->setResponse('true')
            );

        $this->assertCount(2, $collection->getEdges());
    }

    public function testRemoveEdgesFromNode()
    {
        $test = (new Edge())
            ->setFromNodeKey('from')
            ->setToNodeKey('to')
            ->setResponse('test');
        $collection = new EdgeCollection();
        $collection
            ->addEdge($test)
            ->addEdge(
                (new Edge())
                    ->setFromNodeKey('one')
                    ->setToNodeKey('two')
                    ->setResponse('true'))
            ->removeEdgesFromNode('one');
        $this->assertCount(1, $collection->getEdges());
    }
}
