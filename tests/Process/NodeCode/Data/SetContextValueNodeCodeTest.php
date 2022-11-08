<?php

namespace NoLoCo\Core\Tests\Process\NodeCode\Data;

use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\NodeCode\Data\SetContextValueNodeCode;
use NoLoCo\Core\Process\Result\ResultInterface;
use PHPUnit\Framework\TestCase;

class SetContextValueNodeCodeTest extends TestCase
{
    protected SetContextValueNodeCode $node;

    protected function setUp(): void
    {
        $this->node = new SetContextValueNodeCode();
    }

    public function testGetConfigurationDescriptions()
    {
        $configuration = $this->node->getConfigurationDescriptions();
        $this->assertEquals(3, count($configuration));
    }

    public function testProcess()
    {
        $this->node->addConfiguration(
            [
                SetContextValueNodeCode::VALUE => 1,
                SetContextValueNodeCode::CONTEXT_PATH => 'one',
                SetContextValueNodeCode::VALUE_TYPE => SetContextValueNodeCode::OPTION_INT
            ]
        );
        $context = (new Context());
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertIsInt($context->get('one'));
        $this->assertEquals(1, $context->get('one'));
    }

    public function testString()
    {
        $this->node->addConfiguration(
            [
                SetContextValueNodeCode::VALUE => 1,
                SetContextValueNodeCode::CONTEXT_PATH => 'one',
                SetContextValueNodeCode::VALUE_TYPE => SetContextValueNodeCode::OPTION_STRING
            ]
        );
        $context = (new Context());
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertIsString($context->get('one'));
        $this->assertEquals('1', $context->get('one'));
    }

    public function testFloat()
    {
        $this->node->addConfiguration(
            [
                SetContextValueNodeCode::VALUE => 1,
                SetContextValueNodeCode::CONTEXT_PATH => 'one',
                SetContextValueNodeCode::VALUE_TYPE => SetContextValueNodeCode::OPTION_FLOAT
            ]
        );
        $context = (new Context());
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertIsFloat($context->get('one'));
    }

    public function testDeepWrite()
    {
        $this->node->addConfiguration(
            [
                SetContextValueNodeCode::VALUE => 1,
                SetContextValueNodeCode::CONTEXT_PATH => 'one|two',
                SetContextValueNodeCode::VALUE_TYPE => SetContextValueNodeCode::OPTION_INT
            ]
        );
        $context = (new Context())->set('one', []);
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertEquals(1, $context->get('one')['two']);
    }
}
