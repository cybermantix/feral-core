<?php


namespace NoLoCo\Core\Utility\Filter\Comparator;


interface ScalarToArrayComparatorInterface
{
    /**
     * Compare a scalar to an array
     * @param $actual
     * @param array $testValue
     * @return bool
     */
    public function compareScalarToArray($actual, array $testValue): bool;
}
