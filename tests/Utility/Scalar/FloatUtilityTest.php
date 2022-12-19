<?php

namespace Feral\Core\Tests\Utility\Scalar;

use Feral\Core\Utility\Scalar\FloatUtility;
use PHPUnit\Framework\TestCase;

class FloatUtilityTest extends TestCase
{
    public function testEqual()
    {
        $this->assertTrue(FloatUtility::isEqual(0.0, 0.0));
        $this->assertTrue(FloatUtility::isEqual(1.0, 1.0));
        $this->assertTrue(FloatUtility::isEqual(-1.0, -1.0));
        $this->assertTrue(FloatUtility::isEqual(0.0000000000001, 0.0000000000001));
        $this->assertTrue(FloatUtility::isEqual(-0.0000000000001, -0.0000000000001));
        $this->assertTrue(FloatUtility::isEqual(PHP_FLOAT_MAX, PHP_FLOAT_MAX));
        $this->assertTrue(FloatUtility::isEqual(PHP_FLOAT_MIN, PHP_FLOAT_MIN));
        $this->assertFalse(FloatUtility::isEqual(0.0, PHP_FLOAT_MAX));
        //$this->assertFalse(FloatUtility::isEqual(0.0, PHP_FLOAT_MIN); // too small to test
        $this->assertFalse(FloatUtility::isEqual(PHP_FLOAT_MIN, PHP_FLOAT_MAX));
    }

    public function testGreater()
    {
        $this->assertTrue(FloatUtility::isGreater(1.0, 0.0));
        $this->assertTrue(FloatUtility::isGreater(-0.0, -1.0));
        $this->assertTrue(FloatUtility::isGreater(0.00000001, 0.000000001));
        $this->assertTrue(FloatUtility::isGreater(PHP_FLOAT_MAX, PHP_FLOAT_MIN));
        $this->assertFalse(FloatUtility::isGreater(0.0, PHP_FLOAT_MAX));
        $this->assertFalse(FloatUtility::isGreater(-1.0, 0.0));
    }

    public function testLess()
    {
        $this->assertTrue(FloatUtility::isLess(0.0, 1.0));
        $this->assertTrue(FloatUtility::isLess(-1.0, 0.0));
        $this->assertTrue(FloatUtility::isLess(0.000000001, 0.00000001));
        $this->assertTrue(FloatUtility::isLess(PHP_FLOAT_MIN, PHP_FLOAT_MAX));
        $this->assertFalse(FloatUtility::isLess(1.0, 0.0));
        $this->assertFalse(FloatUtility::isLess(PHP_FLOAT_MAX, 0.0));
    }

    public function testIsGreaterOrEqual()
    {
        $this->assertTrue(FloatUtility::isGreaterOrEqual(0.0, 0.0));
        $this->assertTrue(FloatUtility::isGreaterOrEqual(1.0, 0.0));
        $this->assertTrue(FloatUtility::isGreaterOrEqual(0.000000001, 0.000000001));
        $this->assertTrue(FloatUtility::isGreaterOrEqual(0.00000001, 0.000000001));
        $this->assertTrue(FloatUtility::isGreaterOrEqual(PHP_FLOAT_MAX, PHP_FLOAT_MAX - 1.0));
        $this->assertFalse(FloatUtility::isGreaterOrEqual(-1.0, 0.0));
    }

    public function testIsLessOrEqual()
    {
        $this->assertTrue(FloatUtility::isLessOrEqual(0.0, 0.0));
        $this->assertTrue(FloatUtility::isLessOrEqual(0.0, 1.0));
        $this->assertTrue(FloatUtility::isLessOrEqual(0.000000001, 0.000000001));
        $this->assertTrue(FloatUtility::isLessOrEqual(0.000000001, 0.00000001));
        $this->assertTrue(FloatUtility::isLessOrEqual(PHP_FLOAT_MAX - 1.0, PHP_FLOAT_MAX));
        $this->assertFalse(FloatUtility::isLessOrEqual(1.0, 0.0));
    }

    public function testIsGreaterThanZero()
    {
        $this->assertTrue(FloatUtility::isGreaterThanZero(1.0));
        $this->assertTrue(FloatUtility::isGreaterThanZero(0.00000001));
        $this->assertTrue(FloatUtility::isGreaterThanZero(PHP_FLOAT_MAX));
        $this->assertFalse(FloatUtility::isGreaterThanZero(0.0));
        $this->assertFalse(FloatUtility::isGreaterThanZero(-0.00000001));
        $this->assertFalse(FloatUtility::isGreaterThanZero(PHP_FLOAT_MIN));
    }

    public function testIsLessThanZero()
    {
        $this->assertTrue(FloatUtility::isLessThanZero(-1.0));
        $this->assertTrue(FloatUtility::isLessThanZero(-0.00000001));
        //$this->assertTrue(FloatUtility::isLessThanZero(PHP_FLOAT_MIN); //too small to work!
        $this->assertFalse(FloatUtility::isLessThanZero(0.0));
        $this->assertFalse(FloatUtility::isLessThanZero(0.00000001));
        $this->assertFalse(FloatUtility::isLessThanZero(PHP_FLOAT_MAX));
    }

    public function testToString()
    {
        $this->assertEquals('0.0', FloatUtility::toString(0.0, 1));
        $this->assertEquals('0.000000000000', FloatUtility::toString(0.0, 12));
        $this->assertEquals('-1.0', FloatUtility::toString(-1.0, 1));
        $this->assertEquals('-1.000000000000', FloatUtility::toString(-1.0, 12));
        $this->assertEquals('1.0', FloatUtility::toString(1.0, 1));
        $this->assertEquals('1.000000000000', FloatUtility::toString(1.0, 12));
    }
}
