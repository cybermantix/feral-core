<?php

namespace Tests\Unit\Process\Node\Context;

use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\Node\Context\SetContextValueNode;
use NoLoCo\Core\Process\Node\NodeInterface;
use NoLoCo\Core\Process\Result\Result;
use NoLoCo\Core\Utility\Search\DataPathReader;
use PHPUnit\Framework\TestCase;
use stdClass;

class SetContextValueNodeTest extends TestCase
{

    public function testProcess()
    {
        $context = new Context();
        $node = (new SetContextValueNode(
            new DataPathReader(),
            [
                NodeInterface::CONTEXT_KEY => 'test',
                SetContextValueNode::VALUE => 'testValue'
            ]
        ));
        $results = $node->process($context);
        $this->assertEquals('testValue', $context->get('test'));
        $this->assertEquals(Result::OK, $results->getStatus());
        $this->assertStringContainsString('Added a new value', $results->getMessage());

        $node->addConfiguration(SetContextValueNode::VALUE, 'second test');
        $results = $node->process($context);
        $this->assertEquals('second test', $context->get('test'));
        $this->assertEquals(Result::OK, $results->getStatus());
        $this->assertStringContainsString('Updated a value', $results->getMessage());

        $node->addConfiguration(SetContextValueNode::VALUE, ['third', 'test']);
        $results = $node->process($context);
        $this->assertEquals(['third', 'test'], $context->get('test'));
        $this->assertEquals(Result::OK, $results->getStatus());
        $this->assertStringContainsString('Updated a value', $results->getMessage());

        $obj = new stdClass();
        $obj->test = 'object test value';
        $node->addConfiguration(SetContextValueNode::VALUE, $obj);
        $results = $node->process($context);
        $this->assertEquals($obj, $context->get('test'));
        $this->assertEquals(Result::OK, $results->getStatus());
        $this->assertStringContainsString('Updated a value', $results->getMessage());
    }
}
