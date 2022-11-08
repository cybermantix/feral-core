<?php

namespace NoLoCo\Core\Tests\Process\Validator;

use NoLoCo\Core\Process\Node\NodeInterface;
use NoLoCo\Core\Process\Validator\HasStartNodeValidator;
use NoLoCo\Core\Process\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class HasStartNodeValidatorTest extends TestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->validator = new HasStartNodeValidator();
    }

    public function testGetValidationError()
    {
        $mockNode = $this->createMock(NodeInterface::class);
        $mockNode->method('getKey')->willReturn('two');
        $error = $this->validator->getValidationError('one', [
            $mockNode
        ], []);
        $this->assertNotNull($error);
    }

    public function testNoError()
    {
        $mockNode = $this->createMock(NodeInterface::class);
        $mockNode->method('getKey')->willReturn('one');
        $error = $this->validator->getValidationError('one', [
            $mockNode
        ], []);
        $this->assertNull($error);
    }
}
