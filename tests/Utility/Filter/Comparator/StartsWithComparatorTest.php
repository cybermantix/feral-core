<?php

namespace Tests\Unit\Filter\Comparator;

use NoLoCo\Core\Utility\Filter\Comparator\StartsWithComparator;
use PHPUnit\Framework\TestCase;

class StartsWithComparatorTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new StartsWithComparator();
    }

    public function testCompareScalarToScalar()
    {
        $this->assertTrue($this->comparator->compareScalarToScalar('onetwo', 'one'));
        $this->assertTrue($this->comparator->compareScalarToScalar(123, 1));
        $this->assertFalse($this->comparator->compareScalarToScalar('onetwo', 'two'));
        $this->assertFalse($this->comparator->compareScalarToScalar(123, 2));
    }

    public function testCompareArrayToScalar()
    {
        $this->assertTrue($this->comparator->compareArrayToScalar(['one', 'two'], 'one'));
        $this->assertTrue($this->comparator->compareArrayToScalar([1,2,3,4,5], 1));
        $this->assertTrue($this->comparator->compareArrayToScalar([true, false], true));
        $this->assertFalse($this->comparator->compareArrayToScalar(['two'], 'one'));
        $this->assertFalse($this->comparator->compareArrayToScalar([2], 1));
        $this->assertFalse($this->comparator->compareArrayToScalar([1.2], 1.1));
        $this->assertFalse($this->comparator->compareArrayToScalar([false], true));

    }

    public function testCompareArrayToArray()
    {
        $this->assertTrue($this->comparator->compareArrayToArray(['one', 'two', 'three'], ['one', 'two']));
        $this->assertFalse($this->comparator->compareArrayToArray(['three', 'four'], ['one', 'two']));
    }
}
