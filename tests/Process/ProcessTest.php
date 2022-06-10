<?php

namespace Tests\Unit\Process;

use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Edge\Edge;
use NoLoCo\Core\Process\Exception\MaximumNodeRunsException;
use NoLoCo\Core\Process\Node\AbstractNode;
use NoLoCo\Core\Process\Process;
use NoLoCo\Core\Process\Result\Result;
use NoLoCo\Core\Process\Result\ResultInterface;
use NoLoCo\Core\Process\Trace\ProcessTraceCollectorInterface;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

class ProcessTest extends TestCase
{
    protected Process $process;
    protected EventDispatcherInterface $eventDispatcher;

    protected function setUp(): void
    {
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->process = new Process($this->eventDispatcher);
    }

    public function testRemoveEdge()
    {
        $this->eventDispatcher->expects($this->exactly(6))->method('dispatch');
        $edge = (new Edge())
            ->setFromNodeKey('two')
            ->setToNodeKey('one')
            ->setResponse('test');
        $this->process
            ->setStartNodeKey('one')
            ->addNode(new TestNode('one'))
            ->addNode(new TestNode('two'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('two')
                ->setResponse('test'))
            ->addEdge($edge)
            ->removeEdge($edge);
        $this->process->run((new Context()));
    }

    public function testRun()
    {
        $this->eventDispatcher->expects($this->exactly(6))->method('dispatch');
        $this->process
            ->setStartNodeKey('one')
            ->addNode(new TestNode('one'))
            ->addNode(new TestNode('two'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('two')
                ->setResponse('test'))
            ;
        $this->process->run((new Context()));
    }

    public function testRemoveEdgesToNode()
    {
        $this->eventDispatcher->expects($this->exactly(8))->method('dispatch');
        $this->process
            ->setStartNodeKey('one')
            ->addNode(new TestNode('one'))
            ->addNode(new TestNode('two'))
            ->addNode(new TestNode('three'))
            ->addNode( new TestNode('four'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('two')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('three')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('two')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('three')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->removeEdgesToNode('four')
            ;
        $this->process->run((new Context()));
    }

    public function testRemoveNodeByKey()
    {
        $this->eventDispatcher->expects($this->exactly(8))->method('dispatch');
        $this->process
            ->setStartNodeKey('one')
            ->addNode(new TestNode('one'))
            ->addNode(new TestNode('two'))
            ->addNode(new TestNode('three'))
            ->addNode( new TestNode('four'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('two')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('three')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('two')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('three')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->removeNodeByKey('four')
        ;
        $this->process->run((new Context()));
    }

    public function testAddEdge()
    {
        $this->eventDispatcher->expects($this->exactly(6))->method('dispatch');
        $this->process
            ->setStartNodeKey('one')
            ->addNode(new TestNode('one'))
            ->addNode(new TestNode('two'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('two')
                ->setResponse('test'))
        ;
        $this->process->run((new Context()));
    }

    public function testRemoveEdgesFromNode()
    {
        $this->eventDispatcher->expects($this->exactly(4))->method('dispatch');
        $this->process
            ->setStartNodeKey('one')
            ->addNode(new TestNode('one'))
            ->addNode(new TestNode('two'))
            ->addNode(new TestNode('three'))
            ->addNode( new TestNode('four'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('two')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('three')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('two')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('three')
                ->setToNodeKey('four')
                ->setResponse('test'))
        ;
        $this->process->removeEdgesFromNode('one');
        $this->process->run((new Context()));
    }

    public function testStartNodeKey()
    {
        $this->eventDispatcher->expects($this->exactly(6))->method('dispatch');
        $this->process
            ->setStartNodeKey('one')
            ->addNode(new TestNode('one'))
            ->addNode(new TestNode('two'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('two')
                ->setResponse('test'))
        ;
        $this->process->run((new Context()));
    }

    public function testRemoveNode()
    {
        $this->eventDispatcher->expects($this->exactly(8))->method('dispatch');
        $node = new TestNode('four');
        $this->process
            ->setStartNodeKey('one')
            ->addNode(new TestNode('one'))
            ->addNode(new TestNode('two'))
            ->addNode(new TestNode('three'))
            ->addNode($node)
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('two')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('three')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('two')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->addEdge((new Edge())
                ->setFromNodeKey('three')
                ->setToNodeKey('four')
                ->setResponse('test'))
            ->removeNode($node)
        ;
        $this->process->run((new Context()));
    }

    public function testAddNode()
    {
        $this->eventDispatcher->expects($this->exactly(6))->method('dispatch');
        $this->process
            ->setStartNodeKey('one')
            ->addNode(new TestNode('one'))
            ->addNode(new TestNode('two'))
            ->addEdge((new Edge())
                ->setFromNodeKey('one')
                ->setToNodeKey('two')
                ->setResponse('test'))
        ;
        $this->process->run((new Context()));
    }
}

class TestNode extends AbstractNode
{
    protected string $nodeKey;

    protected string $status;

    public function __construct(string $nodeKey, string $status = 'test')
    {
        $this->nodeKey = $nodeKey;
        $this->status = $status;
    }

    /**
     * @inheritDoc
     */
    public function getNodeKey(): string
    {
        return $this->nodeKey;
    }

    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        return (new Result())->setStatus($this->status)->setMessage('Just Testing');
    }

}
