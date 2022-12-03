<?php


namespace Nodez\Core\Utility\Filter\Comparator;


class EmptyTest implements ArrayTestInterface, ScalarTestInterface
{
    /**
     * @inheritDoc
     */
    public function testArray(array $actual): bool
    {
        return empty($actual);
    }

    /**
     * @inheritDoc
     */
    public function testScalar($actual): bool
    {
        return empty($actual);
    }
}
