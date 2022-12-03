<?php

namespace Nodez\Core\Tests\Process\NodeCode\Data;

use Nodez\Core\Process\Context\Context;
use Nodez\Core\Process\NodeCode\Data\SetContextTableNodeCode;
use Nodez\Core\Process\NodeCode\Data\SetContextValueNodeCode;
use Nodez\Core\Process\Result\Description\ResultDescriptionInterface;
use Nodez\Core\Process\Result\ResultInterface;
use PHPUnit\Framework\TestCase;

class SetContextTableNodeCodeTest extends TestCase
{
    protected SetContextTableNodeCode $node;

    protected function setUp(): void
    {
        $this->node = new SetContextTableNodeCode();
    }

    public function testResultDescriptions()
    {
        /** @var ResultDescriptionInterface[] $definitions */
        $definitions = $this->node->getResultDescriptions();
        $this->assertCount(1, $definitions);
        $this->assertEquals(ResultInterface::OK, $definitions[0]->getResult());
    }

    public function testGetConfigurationDescriptions()
    {
        $configuration = $this->node->getConfigurationDescriptions();
        $this->assertEquals(2, count($configuration));
    }

    public function testProcess()
    {
        $this->node->addConfiguration(
            [
                SetContextTableNodeCode::TABLE => [
                    'one' => 1
                ]
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
                SetContextTableNodeCode::TABLE => [
                    'one' => '1'
                ]
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
                SetContextTableNodeCode::TABLE => [
                    'one' => 1.1
                ]
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
                SetContextTableNodeCode::TABLE => [
                    'two' => 1
                ],
                SetContextTableNodeCode::CONTEXT_PATH => 'one'
            ]
        );
        $context = (new Context())->set('one', []);
        $result = $this->node->process($context);
        $this->assertEquals(ResultInterface::OK, $result->getStatus());
        $this->assertEquals(1, $context->get('one')['two']);
    }
}
