<?php

namespace NoLoCo\Core\Tests\Process\Engine;

use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\Edge\Edge;
use NoLoCo\Core\Process\Engine\ProcessEngine;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Process\Result\Result;
use NoLoCo\Core\Process\Result\ResultInterface;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

class ProcessEngineTest extends TestCase
{
    protected ProcessEngine $engine;
    protected EventDispatcherInterface $eventDispatcher;
    protected NodeCodeInterface $node1;
    protected NodeCodeInterface $node2;

    protected function setUp(): void
    {
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->node1 = $this->createMock(NodeCodeInterface::class);
        $this->node1->method('process')->willReturn((new Result())->setStatus(ResultInterface::OK));
        $this->node1->method('getKey')->willReturn('one');
        $this->node2 = $this->createMock(NodeCodeInterface::class);
        $this->node2->method('process')->willReturn((new Result())->setStatus(ResultInterface::STOP));
        $this->node2->method('getKey')->willReturn('two');
        $this->engine = new ProcessEngine($this->eventDispatcher);
    }

    public function testProcess()
    {
        $this->eventDispatcher->expects($this->exactly(6))->method('dispatch');
        $nodes = [
            $this->node1,
            $this->node2
        ];
        $edges = [
            (new Edge())
                ->setFromKey('one')
                ->setToKey('two')
                ->setResult(ResultInterface::OK)
        ];
        $context = new Context();
        $this->engine->process('one', $nodes, $edges, $context);
    }
}
