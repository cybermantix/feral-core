<?php


namespace NoLoCo\Core\Utility\Filter\Comparator;


class ContainsComparator implements ScalarToScalarComparatorInterface, ArrayToScalarComparatorInterface, ArrayToArrayComparatorInterface
{
    public function compareScalarToScalar($actual, $testValue): bool
    {
        if (is_numeric($actual)) {
            $actual = strval($actual);
            $testValue = strval($testValue);
        }
        return false !== strpos($actual, $testValue);
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToScalar(array $actual, $testValue): bool
    {
        return in_array($testValue, $actual);
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToArray(array $actual, array $testValue): bool
    {
        foreach ($testValue as $item) {
            if (!in_array($item, $actual)) {
                return false;
            }
        }
        return true;
    }
}
