<?php

namespace Tests\Unit\Filter\Comparator;

use Nodez\Core\Utility\Filter\Comparator\Comparator;
use Nodez\Core\Utility\Filter\Criterion;
use PHPUnit\Framework\TestCase;

class ComparatorTest extends TestCase
{
    protected Comparator $comparator;

    protected function setUp(): void
    {
        $this->comparator = new Comparator();
    }

    public function testCompare()
    {
        // EMPTY
        $this->assertTrue($this->comparator->compare('', Criterion::EMPTY));
        $this->assertTrue($this->comparator->compare(0, Criterion::EMPTY));
        $this->assertTrue($this->comparator->compare([], Criterion::EMPTY));
        $this->assertFalse($this->comparator->compare('one', Criterion::EMPTY));
        $this->assertFalse($this->comparator->compare(1, Criterion::EMPTY));
        $this->assertFalse($this->comparator->compare([0], Criterion::EMPTY));

        // NOT EMPTY
        $this->assertTrue($this->comparator->compare('1', Criterion::NOT_EMPTY));
        $this->assertTrue($this->comparator->compare(1, Criterion::NOT_EMPTY));
        $this->assertTrue($this->comparator->compare(['one'], Criterion::NOT_EMPTY));
        $this->assertFalse($this->comparator->compare('', Criterion::NOT_EMPTY));
        $this->assertFalse($this->comparator->compare(0, Criterion::NOT_EMPTY));
        $this->assertFalse($this->comparator->compare([], Criterion::NOT_EMPTY));

        // EQ
        $this->assertTrue($this->comparator->compare('one', Criterion::EQ, 'one'));
        $this->assertTrue($this->comparator->compare(1, Criterion::EQ, 1));
        $this->assertTrue($this->comparator->compare(1.1, Criterion::EQ, 1.1));
        $this->assertTrue($this->comparator->compare(['one'], Criterion::EQ, ['one']));
        $this->assertFalse($this->comparator->compare('one', Criterion::EQ, 'two'));
        $this->assertFalse($this->comparator->compare(['one'], Criterion::EQ, ['two']));

        // NOT
        $this->assertTrue($this->comparator->compare('one', Criterion::NOT, 'two'));
        $this->assertTrue($this->comparator->compare(1, Criterion::NOT, 2));
        $this->assertTrue($this->comparator->compare(1.1, Criterion::NOT, 1.2));
        $this->assertTrue($this->comparator->compare(['one'], Criterion::NOT, ['two']));
        $this->assertFalse($this->comparator->compare('one', Criterion::NOT, 'one'));
        $this->assertFalse($this->comparator->compare(['one'], Criterion::NOT, ['one']));

        // GT
        $this->assertTrue($this->comparator->compare(1, Criterion::GT, 0));
        $this->assertTrue($this->comparator->compare(1.1, Criterion::GT, 1.0));
        $this->assertTrue($this->comparator->compare('b', Criterion::GT, 'a'));
        $this->assertFalse($this->comparator->compare(1, Criterion::GT, 1));
        $this->assertFalse($this->comparator->compare(1.0, Criterion::GT, 1.2));
        $this->assertFalse($this->comparator->compare('b', Criterion::GT, 'b'));

        // GTE
        $this->assertTrue($this->comparator->compare(1, Criterion::GTE, 0));
        $this->assertTrue($this->comparator->compare(1.1, Criterion::GTE, 1.1));
        $this->assertTrue($this->comparator->compare('a', Criterion::GTE, 'a'));
        $this->assertFalse($this->comparator->compare(1.0, Criterion::GTE, 1.2));
        $this->assertFalse($this->comparator->compare('a', Criterion::GTE, 'b'));

        // LT
        $this->assertTrue($this->comparator->compare(0, Criterion::LT, 1));
        $this->assertTrue($this->comparator->compare(1.0, Criterion::LT, 1.1));
        $this->assertTrue($this->comparator->compare('a', Criterion::LT, 'b'));
        $this->assertFalse($this->comparator->compare(1, Criterion::LT, 1));
        $this->assertFalse($this->comparator->compare(1.2, Criterion::LT, 1.0));
        $this->assertFalse($this->comparator->compare('b', Criterion::LT, 'b'));

        // LTE
        $this->assertTrue($this->comparator->compare(0, Criterion::LTE, 0));
        $this->assertTrue($this->comparator->compare(1.0, Criterion::LTE, 1.1));
        $this->assertTrue($this->comparator->compare('a', Criterion::LTE, 'a'));
        $this->assertFalse($this->comparator->compare(1.1, Criterion::LTE, 1.0));
        $this->assertFalse($this->comparator->compare('b', Criterion::LTE, 'a'));

        // IN
        $this->assertTrue($this->comparator->compare(0, Criterion::IN, [0,1,2]));
        $this->assertTrue($this->comparator->compare('one', Criterion::IN, ['one', 'two']));
        $this->assertFalse($this->comparator->compare(1, Criterion::IN, [2,3,4]));

        // NOT IN
        $this->assertTrue($this->comparator->compare(3, Criterion::NIN, [0,1,2]));
        $this->assertTrue($this->comparator->compare('three', Criterion::NIN, ['one', 'two']));
        $this->assertFalse($this->comparator->compare(2, Criterion::NIN, [2,3,4]));

        // STARTS
        $this->assertTrue($this->comparator->compare(123, Criterion::STARTS, 1));
        $this->assertTrue($this->comparator->compare('onetwo', Criterion::STARTS, 'one'));
        $this->assertTrue($this->comparator->compare(['one', 'two'], Criterion::STARTS, 'one'));
        $this->assertTrue($this->comparator->compare(['one', 'two', 'three'], Criterion::STARTS, ['one', 'two']));
        $this->assertFalse($this->comparator->compare('twothree', Criterion::STARTS, 'one'));
        $this->assertFalse($this->comparator->compare(234, Criterion::STARTS, 3));

        // ENDS
        $this->assertTrue($this->comparator->compare(123, Criterion::ENDS, 3));
        $this->assertTrue($this->comparator->compare('onetwo', Criterion::ENDS, 'two'));
        $this->assertTrue($this->comparator->compare(['one', 'two'], Criterion::ENDS, 'two'));
        $this->assertTrue($this->comparator->compare(['zero', 'one', 'two'], Criterion::ENDS, ['one', 'two']));
        $this->assertFalse($this->comparator->compare('twothree', Criterion::ENDS, 'two'));
        $this->assertFalse($this->comparator->compare(234, Criterion::ENDS, 2));

        // CONTAINS
        $this->assertTrue($this->comparator->compare(123, Criterion::CONTAINS, 2));
        $this->assertTrue($this->comparator->compare('onetwothree', Criterion::CONTAINS, 'two'));
        $this->assertTrue($this->comparator->compare(['one', 'two'], Criterion::CONTAINS, 'two'));
        $this->assertTrue($this->comparator->compare(['zero', 'one', 'two'], Criterion::CONTAINS, ['one', 'two']));
        $this->assertFalse($this->comparator->compare('twothree', Criterion::CONTAINS, 'one'));
        $this->assertFalse($this->comparator->compare(234, Criterion::CONTAINS, 1));

        // BETWEEN
        $this->assertTrue($this->comparator->compare(2, Criterion::BETWEEN, [1,3]));
        $this->assertTrue($this->comparator->compare(2, Criterion::BETWEEN, [2,3]));
        $this->assertTrue($this->comparator->compare('m', Criterion::BETWEEN, ['a', 'z']));
        $this->assertFalse($this->comparator->compare('1', Criterion::BETWEEN, [2,3]));
        $this->assertFalse($this->comparator->compare('a', Criterion::BETWEEN, ['b', 'z']));
    }
}
