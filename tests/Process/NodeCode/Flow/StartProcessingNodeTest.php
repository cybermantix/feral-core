<?php

namespace Feral\Core\Tests\Process\NodeCode\Flow;

use Feral\Core\Process\Context\Context;
use Feral\Core\Process\NodeCode\Flow\ContextValueComparatorNodeCode;
use Feral\Core\Process\NodeCode\Flow\StartProcessingNode;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\ResultInterface;
use PHPUnit\Framework\TestCase;

class StartProcessingNodeTest extends TestCase
{
    public function testProcess()
    {
        $context = new Context();
        $node = new StartProcessingNode();
        $result = $node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
    }

    public function testResultDescriptions()
    {
        $node = new StartProcessingNode();
        /** @var ResultDescriptionInterface[] $definitions */
        $definitions = $node->getResultDescriptions();
        $this->assertCount(1, $definitions);
        $this->assertEquals(ResultInterface::OK, $definitions[0]->getResult());
    }
}
