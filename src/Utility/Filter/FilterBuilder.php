<?php


namespace Nodez\Core\Utility\Filter;

use DateTimeImmutable;
use Nodez\Core\Utility\DateTime\DateTimeFormats;
use Nodez\Core\Utility\Filter\Exception\CriterionException;
use Nodez\Core\Utility\Filter\Exception\FilterLimitException;
use Nodez\Core\Utility\Scalar\FloatUtility;

/**
 * Class FilterBuilder
 * Build a filter using common language based function names.
 *
 * EXAMPLE:
 *    $filter = $builder
 *                ->init()
 *                ->withPage(2)
 *                ->withLimit(10)
 *                ->equal('foo', 'bar')
 *                ->equal('foo', 'bang') // foo = bar OR foo = bang
 *                ->build();
 *
 * @package Nodez\Core\Utility\Entity\Filter
 */
class FilterBuilder
{
    /**
     * Set a limit on the number of records that can be requested.
     */
    const DEFAULT_MAX_LIMIT = 1000;

    /**
     * Restrict the limit to maximum value to protect
     * the underlying persistent data store.
     *
     * @var int
     */
    protected int $maxLimit = self::DEFAULT_MAX_LIMIT;

    /**
     * The filter being built.
     *
     * @var Filter
     */
    protected Filter $filter;

    /**
     * FilterBuilder constructor.
     *
     * @param int $maxLimit
     */
    public function __construct(int $maxLimit = self::DEFAULT_MAX_LIMIT)
    {
        $this->maxLimit = $maxLimit;
    }

    /**
     * Set the maximum limit this builder can accept.
     *
     * @param  int $maxLimit
     * @return FilterBuilder
     */
    public function setMaxLimit(int $maxLimit) : self
    {
        $this->maxLimit = $maxLimit;
        return $this;
    }

    /**
     * Initialize the build with a filter.
     *
     * @param  Filter|null $filter
     * @return $this
     */
    public function init(Filter $filter = null) : self
    {
        if ($filter) {
            $this->filter = $filter;
        } else {
            $this->filter = new Filter();
        }
        return $this;
    }

    /**
     * Get the filter that was built.
     *
     * @return Filter
     */
    public function build() : Filter
    {
        return $this->filter;
    }

    /**
     * Set the page of data to filter out.
     *
     * @param  int $page
     * @return $this
     */
    public function withPage(int $page): self
    {
        $this->filter->setPage($page);
        return $this;
    }

    /**
     * The number of results for a page. The limit must be greater
     * than zero and less than or equal to the max limit.
     *
     * @param  int $limit
     * @return $this
     * @throws FilterLimitException
     */
    public function withLimit(int $limit): self
    {
        if ($this->maxLimit < $limit) {
            throw new FilterLimitException(
                sprintf(
                    'The requested limit "%d" is greater than the max limit "%d".',
                    $limit,
                    $this->maxLimit
                )
            );
        }
        if ($this->maxLimit <= 0) {
            throw new FilterLimitException(
                sprintf(
                    'The requested limit "%d" must be greater than zero.',
                    $limit
                )
            );
        }
        $this->filter->setLimit($limit);
        return $this;
    }

    /**
     * @param  string $key
     * @param  string $direction
     * @return $this
     * @throws FilterLimitException
     */
    public function addOrder(string $key, string $direction): self
    {
        if (!in_array($direction, [Order::ASC, Order::DESC])) {
            throw new FilterLimitException(
                sprintf(
                    'The requested order direction "%s" must be either ASC or DESC.',
                    $direction
                )
            );
        }
        $order = (new Order())
            ->setKey($key)
            ->setDirection($direction);
        $this->filter->addOrder($order);
        return $this;
    }

    /**
     * @param  string $key
     * @param  string $operator
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function addCriteria(string $key, string $operator, string $value): self
    {
        switch (strtolower($operator)) {
        case Criterion::EQ: 
            return $this->equal($key, $value);
        case Criterion::NOT: 
            return $this->notEqual($key, $value);
        case Criterion::CONTAINS: 
            return $this->contains($key, $value);
        case Criterion::STARTS: 
            return $this->startsWith($key, $value);
        case Criterion::ENDS: 
            return $this->endsWith($key, $value);
        case Criterion::GT: 
            return $this->greaterThan($key, $value);
        case Criterion::GTE: 
            return $this->greaterThanOrEqualTo($key, $value);
        case Criterion::LT: 
            return $this->lessThan($key, $value);
        case Criterion::LTE: 
            return $this->lessThanOrEqualTo($key, $value);
        case Criterion::BETWEEN: 
            return $this->between($key, $value);
        case Criterion::IN: 
            return $this->in($key, explode(Criterion::DELIMITER, $value));
        case Criterion::NIN: 
            return $this->notIn($key, explode(Criterion::DELIMITER, $value));
        case Criterion::EMPTY: 
            return $this->empty($key);
        case Criterion::NOT_EMPTY: 
            return $this->notEmpty($key);
        default:
            throw new CriterionException(sprintf('Unknown operator "%s".', $operator));
        }
        return $this;
    }

    /**
     * The result set must include values equal to the test value
     *
     * @param  string $key
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function equal(string $key, string $value): self
    {
        $this->validateNotEmpty($value);
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::EQ, $value)
        );
        return $this;
    }

    /**
     * The result set should not contain values matching the test value.
     *
     * @param  string $key
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function notEqual(string $key, string $value): self
    {
        $this->validateNotEmpty($value);
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::NOT, $value)
        );
        return $this;
    }

    /**
     * The result set should not contain values matching a sub string.
     *
     * @param  string $key
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function contains(string $key, string $value): self
    {
        $this->validateNotEmpty($value);
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::CONTAINS, $value)
        );
        return $this;
    }

    /**
     * The result set should not contain values whos contents start with a string
     *
     * @param  string $key
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function startsWith(string $key, string $value): self
    {
        $this->validateNotEmpty($value);
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::STARTS, $value)
        );
        return $this;
    }

    /**
     * The result set should not contain values whos contents end with a string
     *
     * @param  string $key
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function endsWith(string $key, string $value): self
    {
        $this->validateNotEmpty($value);
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::ENDS, $value)
        );
        return $this;
    }

    /**
     * The result set should contain only values greater than the test value
     *
     * @param  string $key
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function greaterThan(string $key, string $value): self
    {
        $this->validateNotEmpty($value);
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::GT, $value)
        );
        return $this;
    }

    /**
     * The result set should contain only values greater than or equal to the test value
     *
     * @param  string $key
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function greaterThanOrEqualTo(string $key, string $value): self
    {
        $this->validateNotEmpty($value);
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::GTE, $value)
        );
        return $this;
    }

    /**
     * The result set should contain only values less than the test value
     *
     * @param  string $key
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function lessThan(string $key, string $value): self
    {
        $this->validateNotEmpty($value);
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::LT, $value)
        );
        return $this;
    }

    /**
     * The result set should contain only values less than the test value
     *
     * @param  string $key
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function lessThanOrEqualTo(string $key, string $value): self
    {
        $this->validateNotEmpty($value);
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::LTE, $value)
        );
        return $this;
    }

    /**
     * The result set should be between (inclusive) two values in a string delimited by
     * the criterion delimiter.
     *
     * @param  string $key
     * @param  string $value
     * @return $this
     * @throws CriterionException
     */
    public function between(string $key, string $value): self
    {
        $this->validateNotEmpty($value);
        if (1 != substr_count($value, Criterion::DELIMITER)) {
            throw new CriterionException(sprintf('The value "%s" must contain two values.', $value));
        }
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::BETWEEN, $value)
        );
        return $this;
    }

    /**
     * The result set should be between (inclusive) two string values.
     *
     * @param  string $key
     * @param  string $rangeStart
     * @param  string $rangeEnd
     * @return $this
     * @throws CriterionException
     */
    public function betweenStringRange(string $key, string $rangeStart, string $rangeEnd): self
    {
        $this->between($key, implode(Criterion::DELIMITER, [$rangeStart, $rangeEnd]));
        return $this;
    }

    /**
     * The result set should be between (inclusive) two int values.
     *
     * @param  string $key
     * @param  int    $rangeStart
     * @param  int    $rangeEnd
     * @return $this
     * @throws CriterionException
     */
    public function betweenIntRange(string $key, int $rangeStart, int $rangeEnd): self
    {
        if ($rangeStart >= $rangeEnd) {
            throw new CriterionException(
                sprintf(
                    'The start range value "%d" must be less than the end range value "%d".',
                    $rangeStart,
                    $rangeEnd
                )
            );
        }
        $this->between($key, implode(Criterion::DELIMITER, [$rangeStart, $rangeEnd]));
        return $this;
    }

    /**
     * The result set should be between (inclusive) two float values.
     *
     * @param  string            $key
     * @param  DateTimeImmutable $rangeStart
     * @param  DateTimeImmutable $rangeEnd
     * @return $this
     * @throws CriterionException
     */
    public function betweenDateTimeRange(string $key, DateTimeImmutable $rangeStart, DateTimeImmutable $rangeEnd): self
    {
        $start = $rangeStart->format(DateTimeFormats::MYSQL);
        $end = $rangeEnd->format(DateTimeFormats::MYSQL);
        if ($rangeStart >= $rangeEnd) {
            throw new CriterionException(
                sprintf(
                    'The start range value "%s" must be less than the end range value "%s".',
                    $start,
                    $end
                )
            );
        }
        $this->between($key, implode(Criterion::DELIMITER, [$start, $end]));
        return $this;
    }

    /**
     * The result set should be between (inclusive) two float values.
     *
     * @param  string $key
     * @param  float  $rangeStart
     * @param  float  $rangeEnd
     * @return $this
     * @throws CriterionException
     */
    public function betweenFloatRange(string $key, float $rangeStart, float $rangeEnd): self
    {
        if (FloatUtility::isGreaterOrEqual($rangeStart, $rangeEnd)) {
            throw new CriterionException(
                sprintf(
                    'The start range value "%0.4f" must be less than the end range value "%0.4f".',
                    $rangeStart,
                    $rangeEnd
                )
            );
        }
        $this->between($key, implode(Criterion::DELIMITER, [$rangeStart, $rangeEnd]));
        return $this;
    }

    /**
     * The result set contains a value in a set of values.
     *
     * @param  string                 $key
     * @param  string[]|int[]|float[] $values
     * @return $this
     */
    public function in(string $key, array $values) : self
    {
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::IN, implode(Criterion::DELIMITER, $values))
        );
        return $this;
    }

    /**
     * The result set does not contain a value in a set of values.
     *
     * @param  string                 $key
     * @param  string[]|int[]|float[] $values
     * @return $this
     */
    public function notIn(string $key, array $values) : self
    {
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::NIN, implode(Criterion::DELIMITER, $values))
        );
        return $this;
    }

    /**
     * The result set contains a value that is empty
     *
     * @param  string $key
     * @return $this
     */
    public function empty(string $key) : self
    {
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::EMPTY, '')
        );
        return $this;
    }

    /**
     * The result set contains a value that is not empty
     *
     * @param  string $key
     * @return $this
     */
    public function notEmpty(string $key) : self
    {
        $this->filter->addCriteria(
            $this->createCriterion($key, Criterion::NOT_EMPTY, '')
        );
        return $this;
    }

    /**
     * A helper method to create the criterion.
     *
     * @param  string $key
     * @param  string $operator
     * @param  string $value
     * @return Criterion
     */
    protected function createCriterion(string $key, string $operator, string $value): Criterion
    {
        return (new Criterion())
            ->setKey($key)
            ->setOperator($operator)
            ->setValue($value);
    }

    /**
     * @param  string $value
     * @throws CriterionException
     */
    protected function validateNotEmpty(string $value)
    {
        if (is_null($value) || '' == $value) {
            throw new CriterionException('The value cannot be empty.');
        }
    }


}
