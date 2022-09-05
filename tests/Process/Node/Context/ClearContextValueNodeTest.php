<?php

namespace Tests\Unit\Process\Node\Context;

use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\NodeCode\Context\ClearContextValueNode;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Process\Result\Result;
use NoLoCo\Core\Utility\Search\DataPathReader;
use PHPUnit\Framework\TestCase;

class ClearContextValueNodeTest extends TestCase
{

    public function testProcess()
    {
        $context = new Context();
        $node = (new ClearContextValueNode(
            new DataPathReader(),
            [
                NodeCodeInterface::CONTEXT_KEY => 'test'
            ]
        ));
        $context->set('test', 'testing');
        $results = $node->process($context);
        $this->assertNull($context->get('test'));
        $this->assertEquals(Result::OK, $results->getStatus());
        $this->assertStringContainsString('Cleared context value', $results->getMessage());

        $results = $node->process($context);
        $this->assertNull($context->get('test'));
        $this->assertEquals(Result::OK, $results->getStatus());
        $this->assertStringContainsString('No context value', $results->getMessage());
    }
}
