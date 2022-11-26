<?php


namespace NoLoCo\Core\Utility\Filter\Comparator;


interface ArrayToArrayComparatorInterface
{
    /**
     * Compare two arrays
     *
     * @param  array $actual
     * @param  array $testValue
     * @return bool
     */
    public function compareArrayToArray(array $actual, array $testValue): bool;
}
