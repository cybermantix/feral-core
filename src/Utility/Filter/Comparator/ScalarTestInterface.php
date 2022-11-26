<?php


namespace NoLoCo\Core\Utility\Filter\Comparator;


interface ScalarTestInterface
{
    /**
     * Run a test against a single scalar
     *
     * @param  $actual
     * @return bool
     */
    public function testScalar($actual): bool;
}
