<?php


namespace NoLoCo\Core\Utility\Scalar;

/**
 * Class FloatUtility
 * Helpful functions for float variables.
 *
 * @package NoLoCo\Core\Utility\Scalar
 */
class FloatUtility
{
    /**
     * Check if two floats are equal to each other.
     *
     * @param  float $value1
     * @param  float $value2
     * @return bool
     */
    public static function isEqual(float $value1, float $value2): bool
    {
        if (abs($value1 - $value2) < PHP_FLOAT_EPSILON) {
            return true;
        }
        return false;
    }

    /**
     * Check if a float value1 is greater than value2 value.
     *
     * @param  float $value1
     * @param  float $value2
     * @return bool
     */
    public static function isGreater(float $value1, float $value2): bool
    {
        if (self::isEqual($value1, $value2)) {
            return false;
        }
        return $value1 > $value2;
    }

    /**
     * Check if a float value1 is less than value2 value.
     *
     * @param  float $value1
     * @param  float $value2
     * @return bool
     */
    public static function isLess(float $value1, float $value2): bool
    {
        if (self::isEqual($value1, $value2)) {
            return false;
        }
        return $value1 < $value2;
    }

    /**
     * Check if a float value1 is greater than or equal value2 value.
     *
     * @param  float $value1
     * @param  float $value2
     * @return bool
     */
    public static function isGreaterOrEqual(float $value1, float $value2): bool
    {
        if (self::isEqual($value1, $value2)) {
            return true;
        }
        return $value1 > $value2;
    }

    /**
     * Check if a float value1 is less than or equal value2 value.
     *
     * @param  float $value1
     * @param  float $value2
     * @return bool
     */
    public static function isLessOrEqual(float $value1, float $value2): bool
    {
        if (self::isEqual($value1, $value2)) {
            return true;
        }
        return $value1 < $value2;
    }

    /**
     * Check if a float value is greater than zero.
     *
     * @param  float $value
     * @return bool
     */
    public static function isGreaterThanZero(float $value): bool
    {
        return self::isGreater($value, 0.0);
    }

    /**
     * Check if a float value is less than zero
     *
     * @param  float $value
     * @return bool
     */
    public static function isLessThanZero(float $value): bool
    {
        return self::isLess($value, 0.0);
    }

    /**
     * Convert a float to a string with a specific set of decimals to round.
     *
     * @param  float $value
     * @param  int   $decimals
     * @return string
     */
    public static function toString(float $value, int $decimals): string
    {
        return sprintf('%0.' . $decimals . 'f', $value);
    }
}
