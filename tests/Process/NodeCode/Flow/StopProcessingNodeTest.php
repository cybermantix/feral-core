<?php

namespace Feral\Core\Tests\Process\NodeCode\Flow;

use Feral\Core\Process\Context\Context;
use Feral\Core\Process\NodeCode\Flow\StopProcessingNode;
use Feral\Core\Process\Result\ResultInterface;
use PHPUnit\Framework\TestCase;

class StopProcessingNodeTest extends TestCase
{
    public function testProcess()
    {
        $context = new Context();
        $node = new StopProcessingNode();
        $result = $node->process($context);
        $this->assertEquals(ResultInterface::STOP, $result->getStatus());
    }
}
