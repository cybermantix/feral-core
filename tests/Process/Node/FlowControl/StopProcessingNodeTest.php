<?php

namespace Tests\Unit\Process\Node\FlowControl;

use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\Node\FlowControl\StopProcessingNode;
use NoLoCo\Core\Process\Result\Result;
use NoLoCo\Core\Utility\Search\DataPathReader;
use PHPUnit\Framework\TestCase;

class StopProcessingNodeTest extends TestCase
{
    public function testProcess()
    {
        $context = new Context();
        $node = new StopProcessingNode(new DataPathReader());
        $result = $node->process($context);
        $this->assertEquals(Result::STOP, $result->getStatus());
    }
}
