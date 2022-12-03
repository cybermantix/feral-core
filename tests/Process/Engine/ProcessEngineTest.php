<?php

namespace Nodez\Core\Tests\Process\Engine;

use Nodez\Core\Process\Catalog\CatalogInterface;
use Nodez\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Nodez\Core\Process\Context\Context;
use Nodez\Core\Process\Edge\Edge;
use Nodez\Core\Process\Engine\ProcessEngine;
use Nodez\Core\Process\Node\NodeInterface;
use Nodez\Core\Process\NodeCode\NodeCodeFactory;
use Nodez\Core\Process\NodeCode\NodeCodeInterface;
use Nodez\Core\Process\Process;
use Nodez\Core\Process\Result\Result;
use Nodez\Core\Process\Result\ResultInterface;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;

class ProcessEngineTest extends TestCase
{
    protected ProcessEngine $engine;
    protected EventDispatcherInterface $eventDispatcher;
    protected CatalogInterface $catalog;
    protected NodeCodeFactory $factory;
    protected NodeInterface $node1;
    protected NodeInterface $node2;

    protected function setUp(): void
    {
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->factory = $this->createMock(NodeCodeFactory::class);
        $this->catalog = $this->createMock(CatalogInterface::class);
        $this->node1 = $this->createMock(NodeInterface::class);
        $this->node1->method('getKey')->willReturn('one');
        $this->node1->method('getCatalogNodeKey')->willReturn('one');
        $this->node2 = $this->createMock(NodeInterface::class);
        $this->node2->method('getKey')->willReturn('two');
        $this->node2->method('getCatalogNodeKey')->willReturn('two');
        $this->catalog->method('getCatalogNode')->will(
            $this->returnCallback(function ($key) {
                $catalogNode = $this->createMock(CatalogNodeInterface::class);
                $catalogNode->method('getKey')->willReturn($key);
                $catalogNode->method('getNodeCodeKey')->willReturn($key);
                return $catalogNode;
            })
        );
        $this->factory->method('getNodeCode')->will(
            $this->returnCallback(function ($key) {
                $result = new Result();
                $code = match ($key) {
                    'one' => ResultInterface::OK,
                    'two' => ResultInterface::STOP,
                };
                $result->setStatus($code);
                $nodeCode = $this->createMock(NodeCodeInterface::class);
                $nodeCode->method('getKey')->willReturn('one');
                $nodeCode->method('process')->willReturn($result);
                return $nodeCode;
            })
        );
        $this->engine = new ProcessEngine($this->eventDispatcher, $this->catalog, $this->factory);
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
        $process = (new Process())
            ->setNodes($nodes)
            ->setEdges($edges)
            ->setContext($context);
        $this->engine->process($process, 'one');
    }
}
