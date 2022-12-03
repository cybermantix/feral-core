<?php

namespace Tests\Unit\Filter\Comparator;

use Nodez\Core\Utility\Filter\Comparator\InComparator;
use PHPUnit\Framework\TestCase;

class InComparatorTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new InComparator();
    }

    public function testCompareScalarToArray()
    {
        $this->assertTrue($this->comparator->compareScalarToArray('one', ['one']));
        $this->assertTrue($this->comparator->compareScalarToArray(1, [1,2,3,4,5]));
        $this->assertTrue($this->comparator->compareScalarToArray(true, [true]));
        $this->assertFalse($this->comparator->compareScalarToArray('one', ['two']));
        $this->assertFalse($this->comparator->compareScalarToArray(1, [2]));
        $this->assertFalse($this->comparator->compareScalarToArray(1.1, [1.2]));
        $this->assertFalse($this->comparator->compareScalarToArray(true, [false]));

    }

    public function testCompareArrayToArray()
    {
        $this->assertTrue($this->comparator->compareArrayToArray(['one', 'two'], ['one', 'two', 'three']));
        $this->assertFalse($this->comparator->compareArrayToArray(['one', 'two'], ['three', 'four']));
    }
}
