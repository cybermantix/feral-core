<?php

namespace Tests\Unit\Filter\Comparator;

use NoLoCo\Core\Utility\Filter\Comparator\EndsWithComparator;
use PHPUnit\Framework\TestCase;

class EndsWithComparatorTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new EndsWithComparator();
    }

    public function testCompareScalarToScalar()
    {
        $this->assertTrue($this->comparator->compareScalarToScalar('onetwo', 'two'));
        $this->assertTrue($this->comparator->compareScalarToScalar(123, 3));
        $this->assertFalse($this->comparator->compareScalarToScalar('onetwo', 'one'));
        $this->assertFalse($this->comparator->compareScalarToScalar(123, 1));
    }

    public function testCompareArrayToScalar()
    {
        $this->assertTrue($this->comparator->compareArrayToScalar(['one', 'two'], 'two'));
        $this->assertTrue($this->comparator->compareArrayToScalar([1,2,3,4,5], 5));
        $this->assertTrue($this->comparator->compareArrayToScalar([true, false], false));
        $this->assertFalse($this->comparator->compareArrayToScalar(['two'], 'one'));
        $this->assertFalse($this->comparator->compareArrayToScalar([2], 1));
        $this->assertFalse($this->comparator->compareArrayToScalar([1.2], 1.1));
        $this->assertFalse($this->comparator->compareArrayToScalar([false], true));
    }

    public function testCompareArrayToArray()
    {
        $this->assertTrue($this->comparator->compareArrayToArray(['one', 'two', 'three'], ['two', 'three']));
        $this->assertFalse($this->comparator->compareArrayToArray(['one', 'two', 'three'], ['one', 'two']));
    }
}
