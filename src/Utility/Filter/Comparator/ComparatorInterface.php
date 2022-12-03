<?php


namespace Nodez\Core\Utility\Filter\Comparator;


interface ComparatorInterface
{
    /**
     * Compare an actual value and optional test value. Most comparators
     * use both actual and test while some test against constants and don't
     * need the test value.
     *
     * @param  $actual
     * @param  string $test
     * @param  null   $testValue
     * @return bool
     */
    public function compare($actual, string $test, $testValue = null): bool;
}
