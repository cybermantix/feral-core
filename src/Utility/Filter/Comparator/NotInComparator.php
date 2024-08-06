<?php


namespace Feral\Core\Utility\Filter\Comparator;


class NotInComparator implements ScalarToArrayComparatorInterface, ArrayToArrayComparatorInterface
{

    /**
     * @inheritDoc
     */
    public function compareScalarToArray($actual, array $testValue): bool
    {
        return !in_array($actual, $testValue);
    }

    /**
     * @inheritDoc
     */
    public function compareArrayToArray(array $actual, array $testValue): bool
    {
        foreach ($actual as $item) {
            if (in_array($item, $testValue)) {
                return false;
            }
        }
        return true;
    }
}
