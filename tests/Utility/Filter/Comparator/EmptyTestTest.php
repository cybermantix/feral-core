<?php

namespace Tests\Unit\Filter\Comparator;

use NoLoCo\Core\Utility\Filter\Comparator\EmptyTest;
use PHPUnit\Framework\TestCase;

class EmptyTestTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new EmptyTest();
    }

    public function testTestArray()
    {
        $this->assertTrue($this->comparator->testArray([]));
        $this->assertFalse($this->comparator->testArray([1]));
    }

    public function testTestScalar()
    {
        $this->assertTrue($this->comparator->testScalar(0));
        $this->assertTrue($this->comparator->testScalar(0.0));
        $this->assertTrue($this->comparator->testScalar(''));
        $this->assertFalse($this->comparator->testScalar(1));
        $this->assertFalse($this->comparator->testScalar(1.1));
        $this->assertFalse($this->comparator->testScalar('a'));
    }
}
