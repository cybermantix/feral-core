<?php

namespace Feral\Core\Tests\Process\NodeCode\Data;

use Feral\Core\Process\Context\Context;
use Feral\Core\Process\NodeCode\Data\CalculationNodeCode;
use Feral\Core\Process\Result\ResultInterface;
use PHPUnit\Framework\TestCase;

class CalculationNodeCodeTest extends TestCase
{
    private CalculationNodeCode $node;

    protected function setUp(): void
    {
        $this->node = new CalculationNodeCode();
    }

    public function testAddProcess()
    {
        $this->node->addConfiguration(
            [
                CalculationNodeCode::X_CONTEXT_PATH => 'one',
                CalculationNodeCode::Y_CONTEXT_PATH => 'two',
                CalculationNodeCode::RESULT_PATH => 'result',
                CalculationNodeCode::OPERATION => CalculationNodeCode::ADD,
            ]
        );
        $context = (new Context())
            ->set('one', 1)
            ->set('two', 2);
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertIsInt($context->get('result'));
        $this->assertEquals(3, $context->get('result'));
    }

    public function testSubtractProcess()
    {
        $this->node->addConfiguration(
            [
                CalculationNodeCode::X_CONTEXT_PATH => 'one',
                CalculationNodeCode::Y_CONTEXT_PATH => 'two',
                CalculationNodeCode::RESULT_PATH => 'result',
                CalculationNodeCode::OPERATION => CalculationNodeCode::SUBTRACT,
            ]
        );
        $context = (new Context())
            ->set('one', 2.5)
            ->set('two', 1);
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertIsFloat($context->get('result'));
        $this->assertEquals(1.5, $context->get('result'));
    }

    public function testMultiplyProcess()
    {
        $this->node->addConfiguration(
            [
                CalculationNodeCode::X_CONTEXT_PATH => 'one',
                CalculationNodeCode::Y_CONTEXT_PATH => 'two',
                CalculationNodeCode::RESULT_PATH => 'result',
                CalculationNodeCode::OPERATION => CalculationNodeCode::MULTIPLY,
            ]
        );
        $context = (new Context())
            ->set('one', 10)
            ->set('two', 10);
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertIsInt($context->get('result'));
        $this->assertEquals(100, $context->get('result'));
    }

    public function testDivideProcess()
    {
        $this->node->addConfiguration(
            [
                CalculationNodeCode::X_CONTEXT_PATH => 'one',
                CalculationNodeCode::Y_CONTEXT_PATH => 'two',
                CalculationNodeCode::RESULT_PATH => 'result',
                CalculationNodeCode::OPERATION => CalculationNodeCode::DIVIDE,
            ]
        );
        $context = (new Context())
            ->set('one', 10)
            ->set('two', 10);
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertIsInt($context->get('result'));
        $this->assertEquals(1, $context->get('result'));
    }

    public function testPowerProcess()
    {
        $this->node->addConfiguration(
            [
                CalculationNodeCode::X_CONTEXT_PATH => 'one',
                CalculationNodeCode::Y_CONTEXT_PATH => 'two',
                CalculationNodeCode::RESULT_PATH => 'result',
                CalculationNodeCode::OPERATION => CalculationNodeCode::POWER,
            ]
        );
        $context = (new Context())
            ->set('one', 2)
            ->set('two', 3);
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertIsInt($context->get('result'));
        $this->assertEquals(8, $context->get('result'));
    }
}
