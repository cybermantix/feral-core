<?php


namespace NoLoCo\Core\Utility\Filter\Comparator;

use NoLoCo\Core\Utility\Scalar\FloatUtility;

class NotEqualComparator implements ScalarToScalarComparatorInterface, ArrayToScalarComparatorInterface, ArrayToArrayComparatorInterface

{
    /**
     * @inheritDoc
     */
    public function compareScalarToScalar($actual, $testValue): bool
    {
        if (is_float($actual)) {
            return !FloatUtility::isEqual($actual, floatval($testValue));
        } elseif (is_int($actual)) {
            return $actual != intval($testValue);
        } elseif (is_string($actual)) {
            return 0 != strcmp($actual, strval($testValue));
        } else {
            return $actual != $testValue;
        }
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToArray(array $actual, array $testValue): bool
    {
        return $actual != $testValue;
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToScalar(array $actual, $testValue): bool
    {
        return count($actual) != $testValue;
    }
}
