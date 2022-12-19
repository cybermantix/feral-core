<?php

namespace Tests\Unit\Filter\Comparator;

use Feral\Core\Utility\Filter\Comparator\BetweenComparator;
use PHPUnit\Framework\TestCase;

class BetweenComparatorTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new BetweenComparator();
    }

    public function testCompareScalarToArray()
    {
        $this->assertTrue($this->comparator->compareScalarToArray(2, [1,3]));
        $this->assertTrue($this->comparator->compareScalarToArray(2.1, [2.0, 2.2]));
        $this->assertTrue($this->comparator->compareScalarToArray(2.0, [2.0, 2.2]));
        $this->assertTrue($this->comparator->compareScalarToArray(2.2, [2.0, 2.2]));
        $this->assertTrue($this->comparator->compareScalarToArray('a', ['a', 'b']));
        $this->assertFalse($this->comparator->compareScalarToArray(0, [1,2]));
        $this->assertFalse($this->comparator->compareScalarToArray(1.0, [1.001,2]));
    }

}
