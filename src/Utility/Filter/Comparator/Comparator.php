<?php


namespace NoLoCo\Core\Utility\Filter\Comparator;


use NoLoCo\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;

class Comparator implements ComparatorInterface
{
    protected ComparatorFactory $factory;

    /**
     * Comparator constructor.
     * @param ComparatorFactory|null $factory
     */
    public function __construct(ComparatorFactory $factory = null)
    {
        if($factory) {
            $this->factory = $factory;
        } else {
            $this->factory = new ComparatorFactory();
        }
    }

    /**
     * @inheritDoc
     * @throws UnknownComparatorException
     */
    public function compare($actual, string $test, $testValue = null): bool
    {
        $comparator = $this->factory->build($test);
        if (!is_null($testValue)) {
            if (is_scalar($actual) && is_scalar($testValue)) {
                return $comparator->compareScalarToScalar($actual, $testValue);
            } elseif (is_scalar($actual) && is_array($testValue)) {
                return $comparator->compareScalarToArray($actual, $testValue);
            } elseif (is_array($actual) && is_scalar($testValue)) {
                return $comparator->compareArrayToScalar($actual, $testValue);
            } elseif (is_array($actual) && is_array($testValue)) {
                return $comparator->compareArrayToArray($actual, $testValue);
            } else {
                throw new UnknownComparatorException(sprintf(
                    'Unknown value types for actual and test value for comparator "%s".',
                    $test
                ));
            }
        } else {
            if (is_scalar($actual)) {
                return $comparator->testScalar($actual);
            } elseif (is_array($actual)) {
                return $comparator->testArray($actual);
            } else {
                throw new UnknownComparatorException(sprintf(
                    'Unknown value type for actual for comparator "%s".',
                    $test
                ));
            }
        }
        throw new UnknownComparatorException('Unknown Comparator issue.');
    }


}
