<?php

namespace NoLoCo\Core\Tests\Process\Validator;

use NoLoCo\Core\Process\Validator\ProcessValidator;
use NoLoCo\Core\Process\Validator\ProcessValidatorInterface;
use NoLoCo\Core\Process\Validator\ValidatorInterface;
use PHPUnit\Framework\TestCase;

class ProcessValidatorTest extends TestCase
{
    public function testValidate()
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('getValidationError')->willReturn('test');
        $validator = new ProcessValidator([$validator]);
        $errors = $validator->validate('one', [], []);
        $this->assertCount(1, $errors);
    }

    public function testNoError()
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $validator->method('getValidationError')->willReturn(null);
        $validator = new ProcessValidator([$validator]);
        $errors = $validator->validate('one', [], []);
        $this->assertEmpty($errors);
    }
}
