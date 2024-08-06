<?php


namespace Feral\Core\Utility\Filter\Comparator;


use Feral\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use Feral\Core\Utility\Filter\Criterion;

class ComparatorFactory
{
    const DEFAULT = [
        Criterion::EQ => '\Feral\Core\Utility\Filter\Comparator\EqualComparator',
        Criterion::NOT => '\Feral\Core\Utility\Filter\Comparator\NotEqualComparator',
        Criterion::GT => '\Feral\Core\Utility\Filter\Comparator\GreaterThanComparator',
        Criterion::GTE => '\Feral\Core\Utility\Filter\Comparator\GreaterThanOrEqualToComparator',
        Criterion::LT => '\Feral\Core\Utility\Filter\Comparator\LessThanComparator',
        Criterion::LTE => '\Feral\Core\Utility\Filter\Comparator\LessThanOrEqualToComparator',
        Criterion::IN => '\Feral\Core\Utility\Filter\Comparator\InComparator',
        Criterion::NIN => '\Feral\Core\Utility\Filter\Comparator\NotInComparator',
        Criterion::BETWEEN => '\Feral\Core\Utility\Filter\Comparator\BetweenComparator',
        Criterion::EMPTY => '\Feral\Core\Utility\Filter\Comparator\EmptyTest',
        Criterion::NOT_EMPTY => '\Feral\Core\Utility\Filter\Comparator\NotEmptyTest',
        Criterion::STARTS => '\Feral\Core\Utility\Filter\Comparator\StartsWithComparator',
        Criterion::ENDS => '\Feral\Core\Utility\Filter\Comparator\EndsWithComparator',
        Criterion::CONTAINS => '\Feral\Core\Utility\Filter\Comparator\ContainsComparator',
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
