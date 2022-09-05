<?php

namespace Tests\Unit\Process\Node\FlowControl;

use NoLoCo\Core\Utility\Filter\Criterion;
use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\NodeCode\FlowControl\ContextValueComparatorNode;
use NoLoCo\Core\Process\Result\Result;
use NoLoCo\Core\Utility\Search\DataPathReader;
use PHPUnit\Framework\TestCase;

class ContextValueComparatorNodeTest extends TestCase
{

    public function testProcessEq()
    {
        $node = new ContextValueComparatorNode(
            new DataPathReader(),
            [
                ContextValueComparatorNode::CONTEXT_KEY => 'test',
                ContextValueComparatorNode::OPERATOR => Criterion::EQ,
                ContextValueComparatorNode::TEST_VALUE => 'testing'
            ]
        );
        $context = (new Context())->set('test', 'testing');
        $results = $node->process($context);
        $this->assertEquals(Result::TRUE, $results->getStatus());

        $context = (new Context())->set('test', 'not-testing');
        $results = $node->process($context);
        $this->assertEquals(Result::FALSE, $results->getStatus());
    }

    public function testProcessNot()
    {
        $node = new ContextValueComparatorNode(
            new DataPathReader(),
            [
                ContextValueComparatorNode::CONTEXT_KEY => 'test',
                ContextValueComparatorNode::OPERATOR => Criterion::NOT,
                ContextValueComparatorNode::TEST_VALUE => 'testing'
            ]
        );
        $context = (new Context())->set('test', 'testing');
        $results = $node->process($context);
        $this->assertEquals(Result::FALSE, $results->getStatus());

        $context = (new Context())->set('test', 'not-testing');
        $results = $node->process($context);
        $this->assertEquals(Result::TRUE, $results->getStatus());
    }

    public function testProcessContains()
    {
        $node = new ContextValueComparatorNode(
            new DataPathReader(),
            [
                ContextValueComparatorNode::CONTEXT_KEY => 'test',
                ContextValueComparatorNode::OPERATOR => Criterion::CONTAINS,
                ContextValueComparatorNode::TEST_VALUE => 'ing'
            ]
        );
        $context = (new Context())->set('test', 'testing');
        $results = $node->process($context);
        $this->assertEquals(Result::TRUE, $results->getStatus());

        $context = (new Context())->set('test', 'not-testxyz');
        $results = $node->process($context);
        $this->assertEquals(Result::FALSE, $results->getStatus());
    }

    public function testProcessIn()
    {
        $node = new ContextValueComparatorNode(
            new DataPathReader(),
            [
                ContextValueComparatorNode::CONTEXT_KEY => 'test',
                ContextValueComparatorNode::OPERATOR => Criterion::IN,
                ContextValueComparatorNode::TEST_VALUE => [1,2,3]
            ]
        );
        $context = (new Context())->set('test', 3);
        $results = $node->process($context);
        $this->assertEquals(Result::TRUE, $results->getStatus());

        $context = (new Context())->set('test', 5);
        $results = $node->process($context);
        $this->assertEquals(Result::FALSE, $results->getStatus());
    }
}
