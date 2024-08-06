<?php


namespace Feral\Core\Utility\Filter\Comparator;

use Feral\Core\Utility\Scalar\FloatUtility;

class LessThanComparator implements ScalarToScalarComparatorInterface, ArrayToScalarComparatorInterface
{
    /**
     * @inheritDoc
     */
    public function compareScalarToScalar($actual, $testValue): bool
    {
        if (is_float($actual)) {
            return FloatUtility::isLess($actual, floatval($testValue));
        } elseif (is_int($actual)) {
            return $actual < intval($testValue);
        } elseif (is_string($actual)) {
            return 0 > strcmp($actual, strval($testValue));
        } else {
            $actual < $testValue;
        }
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToScalar(array $actual, $testValue): bool
    {
        return count($actual) < $testValue;
    }
}
