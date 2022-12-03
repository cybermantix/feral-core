<?php


namespace Nodez\Core\Utility\Filter\Comparator;

class StartsWithComparator implements ScalarToScalarComparatorInterface, ArrayToScalarComparatorInterface, ArrayToArrayComparatorInterface
{
    public function compareScalarToScalar($actual, $testValue): bool
    {
        if (is_numeric($actual)) {
            $actual = strval($actual);
            $testValue = strval($testValue);
        }
        return 0 === strpos($actual, $testValue);
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToScalar(array $actual, $testValue): bool
    {
        return 0 == strcmp(strval($actual[array_key_first($actual)]), strval($testValue));
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToArray(array $actual, array $testValue): bool
    {
        return  array_slice($actual, 0, count($testValue)) == $testValue;
    }
}
