<?php

namespace Tests\Unit\Process;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\AbstractNodeCode;
use NoLoCo\Core\Process\NodeCode\NodeFactory;
use NoLoCo\Core\Process\Process;
use NoLoCo\Core\Process\ProcessBuilder;
use NoLoCo\Core\Process\Result\ResultInterface;
use NoLoCo\Core\Utility\Search\DataPathReaderInterface;
use PHPUnit\Framework\TestCase;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

class ProcessBuilderTest extends TestCase
{
    protected ProcessBuilder $processBuilder;
    protected NodeFactory $nodeFactory;
    protected EventDispatcherInterface $eventDispatcher;

    protected function setUp(): void
    {
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->nodeFactory = $this->createMock(NodeFactory::class);
        $this->processBuilder = new ProcessBuilder($this->eventDispatcher, $this->nodeFactory);
    }

    public function testInit()
    {
        $process = $this->processBuilder
            ->init()
            ->build();
        $this->assertInstanceOf(Process::class, $process);
    }

    public function testBuild()
    {
        $dataPathReader = $this->createMock(DataPathReaderInterface::class);
        $node = (new BuilderTestNode($dataPathReader));
        $this->nodeFactory->expects($this->exactly(3))->method('build')->willReturn($node);
        $json = '
            {
              "start": {
                "alias": "startNode",
                "configuration": {},
                "edges": [
                  {
                    "result": "ok",
                    "node": "test"
                  }
                ]
              },
              "test": {
                "alias": "testNode",
                "configuration": {
                  "url": "https://example.com/",
                  "email": "test@example.com"
                },
                "edges": [
                  {
                    "result": "ok",
                    "node": "test"
                  }
                ]
              },
              "test2": {
                "alias": "testNode",
                "configuration": {
                  "url": "https://example2.com/",
                  "email": "another@example.com"
                },
                "edges": []
              }
            }     
        ';
        $process = $this->processBuilder
            ->init()
            ->withJson($json)
            ->build();
        $this->assertInstanceOf(Process::class, $process);
    }
}

class BuilderTestNode extends AbstractNodeCode
{
    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        return $this->result('test', 'Just Testing');
    }
}
