<?php


namespace NoLoCo\Core\Utility\Filter\Comparator;


use NoLoCo\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use NoLoCo\Core\Utility\Filter\Criterion;

class ComparatorFactory
{
    const DEFAULT = [
        Criterion::EQ => '\NoLoCo\Core\Utility\Filter\Comparator\EqualComparator',
        Criterion::NOT => '\NoLoCo\Core\Utility\Filter\Comparator\NotEqualComparator',
        Criterion::GT => '\NoLoCo\Core\Utility\Filter\Comparator\GreaterThanComparator',
        Criterion::GTE => '\NoLoCo\Core\Utility\Filter\Comparator\GreaterThanOrEqualToComparator',
        Criterion::LT => '\NoLoCo\Core\Utility\Filter\Comparator\LessThanComparator',
        Criterion::LTE => '\NoLoCo\Core\Utility\Filter\Comparator\LessThanOrEqualToComparator',
        Criterion::IN => '\NoLoCo\Core\Utility\Filter\Comparator\InComparator',
        Criterion::NIN => '\NoLoCo\Core\Utility\Filter\Comparator\NotInComparator',
        Criterion::BETWEEN => '\NoLoCo\Core\Utility\Filter\Comparator\BetweenComparator',
        Criterion::EMPTY => '\NoLoCo\Core\Utility\Filter\Comparator\EmptyTest',
        Criterion::NOT_EMPTY => '\NoLoCo\Core\Utility\Filter\Comparator\NotEmptyTest',
        Criterion::STARTS => '\NoLoCo\Core\Utility\Filter\Comparator\StartsWithComparator',
        Criterion::ENDS => '\NoLoCo\Core\Utility\Filter\Comparator\EndsWithComparator',
        Criterion::CONTAINS => '\NoLoCo\Core\Utility\Filter\Comparator\ContainsComparator',
    ];
    protected array $registry = [];

    /**
     * Comparators that have been built.
     *
     * @var array
     */
    protected array $cache = [];

    public function __construct(array $registry = null)
    {
        if (!empty($registry)) {
            $this->registry = $registry;
        } else {
            $this->registry = self::DEFAULT;
        }
    }

    /**
     * @param  string $key
     * @return ScalarTestInterface|ArrayTestInterface|ScalarToScalarComparatorInterface|ArrayToScalarComparatorInterface|ArrayToArrayComparatorInterface|ScalarToArrayComparatorInterface
     * @throws UnknownComparatorException
     */
    public function build(string $key)
    {
        if (!empty($this->registry[$key])) {
            if (empty($this->cache[$key])) {
                $fqcn = $this->registry[$key];
                $this->cache[$key] = new $fqcn();
            }
            return $this->cache[$key];
        } else {
            throw new UnknownComparatorException(sprintf('Unknown Comparator "%s".', $key));
        }
    }
}
