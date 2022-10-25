<?php

namespace NoLoCo\Core\Tests\Process\NodeCode\Flow;

use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\NodeCode\Flow\StopProcessingNode;
use NoLoCo\Core\Process\Result\Result;
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
}
