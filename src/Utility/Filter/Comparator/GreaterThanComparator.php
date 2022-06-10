<?php


namespace NoLoCo\Core\Utility\Filter\Comparator;

use NoLoCo\Core\Utility\Scalar\FloatUtility;

class GreaterThanComparator implements ScalarToScalarComparatorInterface, ArrayToScalarComparatorInterface
{
    /**
     * @inheritDoc
     */
    public function compareScalarToScalar($actual, $testValue): bool
    {
        if (is_float($actual)) {
            return FloatUtility::isGreater($actual, floatval($testValue));
        } elseif (is_int($actual)) {
            return $actual > intval($testValue);
        } elseif (is_string($actual)) {
            return 0 < strcmp($actual, strval($testValue));
        } else {
            return $actual > $testValue;
        }
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToScalar(array $actual, $testValue): bool
    {
        return count($actual) > $testValue;
    }
}
