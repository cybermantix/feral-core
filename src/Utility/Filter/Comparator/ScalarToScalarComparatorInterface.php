<?php


namespace Nodez\Core\Utility\Filter\Comparator;


interface ScalarToScalarComparatorInterface
{
    /**
     * Compare two scalar values and return true or false
     * base on the test.
     *
     * @param  $actual
     * @param  $testValue
     * @return bool
     */
    public function compareScalarToScalar($actual, $testValue): bool;
}
