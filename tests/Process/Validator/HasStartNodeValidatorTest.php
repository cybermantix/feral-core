<?php

namespace Nodez\Core\Tests\Process\Validator;

use Nodez\Core\Process\Node\NodeInterface;
use Nodez\Core\Process\Validator\HasStartNodeValidator;
use Nodez\Core\Process\Validator\ValidatorInterface;
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
