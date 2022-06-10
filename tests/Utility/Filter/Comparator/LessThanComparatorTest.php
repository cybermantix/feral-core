<?php

namespace Tests\Unit\Filter\Comparator;

use NoLoCo\Core\Utility\Filter\Comparator\LessThanComparator;
use PHPUnit\Framework\TestCase;

class LessThanComparatorTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new LessThanComparator();
    }

    public function testCompareScalarToScalar()
    {
        $this->assertTrue($this->comparator->compareScalarToScalar(2, 3));
        $this->assertTrue($this->comparator->compareScalarToScalar(1.0, 1.1));
        $this->assertTrue($this->comparator->compareScalarToScalar('a', 'b'));
        $this->assertFalse($this->comparator->compareScalarToScalar(2, 2));
        $this->assertFalse($this->comparator->compareScalarToScalar(1.1, 1.0));
        $this->assertFalse($this->comparator->compareScalarToScalar('z', 'y'));
    }

    public function testCompareArrayToScalar()
    {
        $this->assertTrue($this->comparator->compareArrayToScalar(['one'], 2));
        $this->assertFalse($this->comparator->compareArrayToScalar(['one', 'two'], 2));
    }
}
