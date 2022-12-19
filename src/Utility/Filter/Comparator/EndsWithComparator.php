<?php


namespace Feral\Core\Utility\Filter\Comparator;


class EndsWithComparator implements ScalarToScalarComparatorInterface, ArrayToScalarComparatorInterface, ArrayToArrayComparatorInterface
{
    public function compareScalarToScalar($actual, $testValue): bool
    {
        if (is_numeric($actual)) {
            $actual = strval($actual);
            $testValue = strval($testValue);
        }
        return strlen($actual) - strlen($testValue) === strpos($actual, $testValue);
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToScalar(array $actual, $testValue): bool
    {
        return 0 == strcmp(strval($actual[array_key_last($actual)]), strval($testValue));
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToArray(array $actual, array $testValue): bool
    {
        return  array_slice($actual, -count($testValue)) == $testValue;
    }
}
