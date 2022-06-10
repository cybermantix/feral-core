<?php

namespace NoLoCo\Core\Utility\Filter\Comparator;

use NoLoCo\Core\Utility\Scalar\FloatUtility;

class BetweenComparator implements ScalarToArrayComparatorInterface
{
    /**
     * @inheritDoc
     */
    public function compareScalarToArray($actual, array $testValue): bool
    {
        list($first, $second) = $testValue;
        if (is_float($actual)) {
            return FloatUtility::isGreaterOrEqual($actual, floatval($first)) &&
                FloatUtility::isLessOrEqual($actual, floatval($second));
        } elseif (is_int($actual)) {
            return $actual >= intval($first) && $actual <= intval($second);
        } else {
            return 0 <= strcmp($actual, strval($first)) && 0 >= strcmp($actual, strval($second));
        }
    }
}
