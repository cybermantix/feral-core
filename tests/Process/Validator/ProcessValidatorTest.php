<?php

namespace NoLoCo\Core\Tests\Process\Validator;

use NoLoCo\Core\Process\ProcessInterface;
use NoLoCo\Core\Process\Validator\ProcessValidator;
use NoLoCo\Core\Process\Validator\ProcessValidatorInterface;
use NoLoCo\Core\Process\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ProcessValidatorTest extends TestCase
{
    public function testValidate()
    {
        $process = $this->createMock(ProcessInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('getValidationError')->willReturn('test');
        $processValidator = new ProcessValidator([$validator]);
        $errors = $processValidator->validate($process);
        $this->assertCount(1, $errors);
    }

    public function testNoError()
    {
        $process = $this->createMock(ProcessInterface::class);
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('getValidationError')->willReturn(null);
        $processValidator = new ProcessValidator([$validator]);
        $errors = $processValidator->validate($process);
        $this->assertEmpty($errors);
    }
}
