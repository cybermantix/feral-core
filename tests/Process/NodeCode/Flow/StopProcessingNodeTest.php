<?php

namespace Feral\Core\Tests\Process\NodeCode\Flow;

use Feral\Core\Process\Context\Context;
use Feral\Core\Process\NodeCode\Flow\StartProcessingNode;
use Feral\Core\Process\NodeCode\Flow\StopProcessingNode;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\Result;
use Feral\Core\Process\Result\ResultInterface;
use PHPUnit\Framework\TestCase;

class StopProcessingNodeTest extends TestCase
{
    public function testProcess()
    {
        $context = new Context();
        $node = new StopProcessingNode();
        $result = $node->process($context);
        $this->assertEquals(Result::STOP, $result->getStatus());
    }

    public function testResultDescriptions()
    {
        $node = new StopProcessingNode();
        /** @var ResultDescriptionInterface[] $definitions */
        $definitions = $node->getResultDescriptions();
        $this->assertCount(1, $definitions);
        $this->assertEquals(ResultInterface::STOP, $definitions[0]->getResult());
    }
}
