<?php

namespace NoLoCo\Core\Tests\Process\Validator;

use NoLoCo\Core\Process\Edge\EdgeInterface;
use NoLoCo\Core\Process\Node\NodeInterface;
use NoLoCo\Core\Process\Validator\EdgesExistValidator;
use NoLoCo\Core\Process\Validator\HasStartNodeValidator;
use NoLoCo\Core\Process\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class EdgesExistValidatorTest extends TestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = new EdgesExistValidator();
    }

    public function testGetValidationError()
    {
        $mockNode1 = $this->createMock(NodeInterface::class);
        $mockNode1->method('getKey')->willReturn('one');
        $mockNode2 = $this->createMock(NodeInterface::class);
        $mockNode2->method('getKey')->willReturn('two');
        $mockEdge = $this->createMock(EdgeInterface::class);
        $mockEdge->method('getFromKey')->willReturn('one');
        $mockEdge->method('getToKey')->willReturn('three');
        $error = $this->validator->getValidationError('one', [
            $mockNode1,
            $mockNode2
        ], [
            $mockEdge
        ]);
        $this->assertNotNull($error);
    }

    public function testNoError()
    {
        $mockNode1 = $this->createMock(NodeInterface::class);
        $mockNode1->method('getKey')->willReturn('one');
        $mockNode2 = $this->createMock(NodeInterface::class);
        $mockNode2->method('getKey')->willReturn('two');
        $mockEdge = $this->createMock(EdgeInterface::class);
        $mockEdge->method('getFromKey')->willReturn('one');
        $mockEdge->method('getToKey')->willReturn('two');
        $error = $this->validator->getValidationError('one', [
            $mockNode1,
            $mockNode2
        ], []);
        $this->assertNull($error);
    }
}
