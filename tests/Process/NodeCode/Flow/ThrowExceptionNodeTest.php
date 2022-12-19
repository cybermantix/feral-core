<?php

namespace Feral\Core\Tests\Process\NodeCode\Flow;

use Feral\Core\Process\Context\Context;
use Feral\Core\Process\Exception\ProcessException;
use Feral\Core\Process\NodeCode\Flow\StartProcessingNode;
use Feral\Core\Process\NodeCode\Flow\ThrowExceptionProcessingNode;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\ResultInterface;
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

