<?php

namespace Tests\Unit\Filter\Comparator;

use Nodez\Core\Utility\Filter\Comparator\NotEmptyTest;
use PHPUnit\Framework\TestCase;

class NotEmptyTestTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new NotEmptyTest();
    }

    public function testTestArray()
    {
        $this->assertTrue($this->comparator->testArray([1]));
        $this->assertFalse($this->comparator->testArray([]));
    }

    public function testTestScalar()
    {
        $this->assertTrue($this->comparator->testScalar(1));
        $this->assertTrue($this->comparator->testScalar(1.0));
        $this->assertTrue($this->comparator->testScalar('a'));
        $this->assertFalse($this->comparator->testScalar(0));
        $this->assertFalse($this->comparator->testScalar(0.0));
        $this->assertFalse($this->comparator->testScalar(''));
    }
}
