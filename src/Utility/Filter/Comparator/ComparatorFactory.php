<?php


namespace Nodez\Core\Utility\Filter\Comparator;


use Nodez\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use Nodez\Core\Utility\Filter\Criterion;

class ComparatorFactory
{
    const DEFAULT = [
        Criterion::EQ => '\Nodez\Core\Utility\Filter\Comparator\EqualComparator',
        Criterion::NOT => '\Nodez\Core\Utility\Filter\Comparator\NotEqualComparator',
        Criterion::GT => '\Nodez\Core\Utility\Filter\Comparator\GreaterThanComparator',
        Criterion::GTE => '\Nodez\Core\Utility\Filter\Comparator\GreaterThanOrEqualToComparator',
        Criterion::LT => '\Nodez\Core\Utility\Filter\Comparator\LessThanComparator',
        Criterion::LTE => '\Nodez\Core\Utility\Filter\Comparator\LessThanOrEqualToComparator',
        Criterion::IN => '\Nodez\Core\Utility\Filter\Comparator\InComparator',
        Criterion::NIN => '\Nodez\Core\Utility\Filter\Comparator\NotInComparator',
        Criterion::BETWEEN => '\Nodez\Core\Utility\Filter\Comparator\BetweenComparator',
        Criterion::EMPTY => '\Nodez\Core\Utility\Filter\Comparator\EmptyTest',
        Criterion::NOT_EMPTY => '\Nodez\Core\Utility\Filter\Comparator\NotEmptyTest',
        Criterion::STARTS => '\Nodez\Core\Utility\Filter\Comparator\StartsWithComparator',
        Criterion::ENDS => '\Nodez\Core\Utility\Filter\Comparator\EndsWithComparator',
        Criterion::CONTAINS => '\Nodez\Core\Utility\Filter\Comparator\ContainsComparator',
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
