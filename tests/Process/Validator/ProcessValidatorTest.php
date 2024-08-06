<?php

namespace Feral\Core\Tests\Process\Validator;

use Feral\Core\Process\ProcessInterface;
use Feral\Core\Process\Validator\ProcessValidator;
use Feral\Core\Process\Validator\ProcessValidatorInterface;
use Feral\Core\Process\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ProcessValidatorTest extends TestCase
{
    public function testValidate()
    {
        $process = $this->createMock(ProcessInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('getValidationError')->willReturn('test');
        $processValidator = new ProcessValidator(new \ArrayIterator([$validator]));
        $errors = $processValidator->validate($process);
        $this->assertCount(1, $errors);
    }

    public function testNoError()
    {
        $process = $this->createMock(ProcessInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('getValidationError')->willReturn(null);
        $processValidator = new ProcessValidator(new \ArrayIterator([$validator]));
        $errors = $processValidator->validate($process);
        $this->assertEmpty($errors);
    }
}
