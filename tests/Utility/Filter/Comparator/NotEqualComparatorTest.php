<?php

namespace Tests\Unit\Filter\Comparator;

use Nodez\Core\Utility\Filter\Comparator\NotEqualComparator;
use PHPUnit\Framework\TestCase;

class NotEqualComparatorTest extends TestCase
{
    protected $comparator;

    protected function setUp(): void
    {
        $this->comparator = new NotEqualComparator();
    }

    public function testCompareScalarToScalar()
    {
        $this->assertTrue($this->comparator->compareScalarToScalar('one', 'two'));
        $this->assertTrue($this->comparator->compareScalarToScalar(1, 2));
        $this->assertTrue($this->comparator->compareScalarToScalar(1.1, 1.2));
        $this->assertTrue($this->comparator->compareScalarToScalar(true, false));
        $this->assertFalse($this->comparator->compareScalarToScalar('one', 'one'));
        $this->assertFalse($this->comparator->compareScalarToScalar(1, 1));
        $this->assertFalse($this->comparator->compareScalarToScalar(1.1, 1.1));
        $this->assertFalse($this->comparator->compareScalarToScalar(true, true));
    }

    public function testCompareArrayToScalar()
    {
        $this->assertTrue($this->comparator->compareArrayToScalar(['one', 'two'], 1));
        $this->assertFalse($this->comparator->compareArrayToScalar(['one'], 1));
    }

    public function testCompareArrayToArray()
    {
        $this->assertTrue($this->comparator->compareArrayToArray(['one'], ['two']));
        $this->assertTrue($this->comparator->compareArrayToArray(['one', 1], ['one', 2]));
        $this->assertTrue($this->comparator->compareArrayToArray(['one' => 'one'], ['two' => 'one']));
        $this->assertFalse($this->comparator->compareArrayToArray(['one'], ['one']));
        $this->assertFalse($this->comparator->compareArrayToArray(['one', 1], ['one', 1]));
        $this->assertFalse($this->comparator->compareArrayToArray(['one' => 'one'], ['one' => 'one']));;
    }
}
