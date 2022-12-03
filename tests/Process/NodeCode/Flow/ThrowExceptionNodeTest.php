<?php

namespace Nodez\Core\Tests\Process\NodeCode\Flow;

use Nodez\Core\Process\Context\Context;
use Nodez\Core\Process\Exception\ProcessException;
use Nodez\Core\Process\NodeCode\Flow\StartProcessingNode;
use Nodez\Core\Process\NodeCode\Flow\ThrowExceptionProcessingNode;
use Nodez\Core\Process\Result\Description\ResultDescriptionInterface;
use Nodez\Core\Process\Result\ResultInterface;
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

