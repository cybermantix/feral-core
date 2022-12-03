<?php

namespace Tests\Unit\Filter\Comparator;

use Nodez\Core\Utility\Filter\Comparator\NotInComparator;
use PHPUnit\Framework\TestCase;

class NotInComparatorTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new NotInComparator();
    }

    public function testCompareScalarToArray()
    {
        $this->assertTrue($this->comparator->compareScalarToArray('two', ['one']));
        $this->assertTrue($this->comparator->compareScalarToArray(6, [1,2,3,4,5]));
        $this->assertTrue($this->comparator->compareScalarToArray(false, [true]));
        $this->assertFalse($this->comparator->compareScalarToArray('two', ['two']));
        $this->assertFalse($this->comparator->compareScalarToArray(2, [2]));
        $this->assertFalse($this->comparator->compareScalarToArray(1.2, [1.2]));
        $this->assertFalse($this->comparator->compareScalarToArray(false, [false]));

    }

    public function testCompareArrayToArray()
    {
        $this->assertTrue($this->comparator->compareArrayToArray(['one', 'two'], ['three', 'four']));
        $this->assertFalse($this->comparator->compareArrayToArray(['one', 'two'], ['one', 'two', 'three']));
    }
}
