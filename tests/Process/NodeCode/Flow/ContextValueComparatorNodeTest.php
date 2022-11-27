<?php

namespace NoLoCo\Core\Tests\Process\NodeCode\Flow;

use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\NodeCode\Flow\ContextValueComparatorNodeCode;
use NoLoCo\Core\Process\Result\Description\ResultDescriptionInterface;
use NoLoCo\Core\Process\Result\Result;
use NoLoCo\Core\Process\Result\ResultInterface;
use NoLoCo\Core\Utility\Filter\Criterion;
use PHPUnit\Framework\TestCase;

class ContextValueComparatorNodeTest extends TestCase
{
    public function testProcessEq()
    {
        $node = (new ContextValueComparatorNodeCode())->addConfiguration(
            [
                ContextValueComparatorNodeCode::CONTEXT_PATH => 'test',
                ContextValueComparatorNodeCode::OPERATOR => Criterion::EQ,
                ContextValueComparatorNodeCode::TEST_VALUE => 'testing'
            ]
        );
        $context = (new Context())->set('test', 'testing');
        $results = $node->process($context);
        $this->assertEquals(Result::TRUE, $results->getStatus());

        $context = (new Context())->set('test', 'not-testing');
        $results = $node->process($context);
        $this->assertEquals(Result::FALSE, $results->getStatus());
    }

    public function testResultDescriptions()
    {
        $node = new ContextValueComparatorNodeCode();
        /** @var ResultDescriptionInterface[] $definitions */
        $definitions = $node->getResultDescriptions();
        $this->assertCount(2, $definitions);
        $this->assertEquals(ResultInterface::TRUE, $definitions[0]->getResult());
        $this->assertEquals(ResultInterface::FALSE, $definitions[1]->getResult());
    }

    public function testProcessNot()
    {
        $node = (new ContextValueComparatorNodeCode())->addConfiguration(
            [
                ContextValueComparatorNodeCode::CONTEXT_PATH => 'test',
                ContextValueComparatorNodeCode::OPERATOR => Criterion::NOT,
                ContextValueComparatorNodeCode::TEST_VALUE => 'testing'
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
        $node = (new ContextValueComparatorNodeCode())->addConfiguration(
            [
                ContextValueComparatorNodeCode::CONTEXT_PATH => 'test',
                ContextValueComparatorNodeCode::OPERATOR => Criterion::CONTAINS,
                ContextValueComparatorNodeCode::TEST_VALUE => 'ing'
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
        $node = (new ContextValueComparatorNodeCode())->addConfiguration(
            [
                ContextValueComparatorNodeCode::CONTEXT_PATH => 'test',
                ContextValueComparatorNodeCode::OPERATOR => Criterion::IN,
                ContextValueComparatorNodeCode::TEST_VALUE => [1,2,3]
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
