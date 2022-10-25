<?php

namespace NoLoCo\Core\Tests\Process\NodeCode\Flow;

use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\NodeCode\Flow\StartProcessingNode;
use NoLoCo\Core\Process\Result\ResultInterface;
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
}
