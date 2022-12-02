<?php

namespace NoLoCo\Core\Tests\Process\NodeCode\Flow;

use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\Exception\ProcessException;
use NoLoCo\Core\Process\NodeCode\Flow\StartProcessingNode;
use NoLoCo\Core\Process\NodeCode\Flow\ThrowExceptionProcessingNode;
use NoLoCo\Core\Process\Result\Description\ResultDescriptionInterface;
use NoLoCo\Core\Process\Result\ResultInterface;
use PHPUnit\Framework\TestCase;

class ThrowExceptionNodeTest extends TestCase
{
    public function testProcess()
    {
        $context = new Context();
        $node = new ThrowExceptionProcessingNode();
        $this->expectException(ProcessException::class);
        $node->process($context);
    }

    public function testResultDescriptions()
    {
        $node = new ThrowExceptionProcessingNode();
        /** @var ResultDescriptionInterface[] $definitions */
        $definitions = $node->getResultDescriptions();
        $this->assertCount(0, $definitions);
    }
}

