<?php

namespace NoLoCo\Core\Utility\Filter\Comparator;

interface ArrayToScalarComparatorInterface
{
    /**
     * Compare an array value to a test sclar
     *
     * @param  array $actual
     * @param  $testValue
     * @return bool
     */
    public function compareArrayToScalar(array $actual, $testValue): bool;
}
