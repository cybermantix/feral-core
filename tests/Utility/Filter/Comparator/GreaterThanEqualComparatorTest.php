<?php

namespace Tests\Unit\Filter\Comparator;

use NoLoCo\Core\Utility\Filter\Comparator\GreaterThanOrEqualToComparator;
use PHPUnit\Framework\TestCase;

class GreaterThanEqualComparatorTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new GreaterThanOrEqualToComparator();
    }

    public function testCompareScalarToScalar()
    {
        $this->assertTrue($this->comparator->compareScalarToScalar(3, 2));
        $this->assertTrue($this->comparator->compareScalarToScalar(3, 3));
        $this->assertTrue($this->comparator->compareScalarToScalar(1.1, 1.0));
        $this->assertTrue($this->comparator->compareScalarToScalar(1.1, 1.1));
        $this->assertTrue($this->comparator->compareScalarToScalar('z', 'y'));
        $this->assertTrue($this->comparator->compareScalarToScalar('z', 'z'));
        $this->assertFalse($this->comparator->compareScalarToScalar(2, 3));
        $this->assertFalse($this->comparator->compareScalarToScalar(1.0, 1.1));
        $this->assertFalse($this->comparator->compareScalarToScalar('y', 'z'));
    }

    public function testCompareArrayToScalar()
    {
        $this->assertTrue($this->comparator->compareArrayToScalar(['one'], 0));
        $this->assertTrue($this->comparator->compareArrayToScalar(['one'], 1));
        $this->assertFalse($this->comparator->compareArrayToScalar(['one', 'two'], 3));
    }
}
