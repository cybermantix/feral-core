<?php

namespace Tests\Unit\Filter\Comparator;

use Feral\Core\Utility\Filter\Comparator\ContainsComparator;
use PHPUnit\Framework\TestCase;

class ContainsComparatorTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new ContainsComparator();
    }

    public function testCompareScalarToScalar()
    {
        $this->assertTrue($this->comparator->compareScalarToScalar('onetwo', 'one'));
        $this->assertTrue($this->comparator->compareScalarToScalar(123, 1));
        $this->assertFalse($this->comparator->compareScalarToScalar('onewo', 'two'));
        $this->assertFalse($this->comparator->compareScalarToScalar(143, 2));
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
