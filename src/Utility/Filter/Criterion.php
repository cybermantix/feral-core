<?php

namespace NoLoCo\Core\Utility\Filter;

/**
 * Class Criteria
 * Criteria is a key/test evaluation set which can filter down
 * a set of data.
 *
 * @package NoLoCo\Core\Utility\Entity\Filter
 */
class Criterion
{
    /**
     * The character used to delimit multiple values.
     */
    const DELIMITER = '|';

    /**
     * Value equals a test value
     * EXAMPLE: `x` == "y"
     */
    const EQ = 'eq';

    /**
     * Value does not equal to a test value
     * EXAMPLE: `x` != "y"
     */
    const NOT = 'not';

    /**
     * A partial string match.
     * EXAMPLE: `x` LIKE "%y%"
     */
    const CONTAINS = 'contains';

    /**
     * Value starts with a string
     * EXAMPLE: `x` LIKE "y%"
     */
    const STARTS = 'starts';

    /**
     * Value ends with a string
     * EXAMPLE: `x` LIKE "%y"
     */
    const ENDS = 'ends';

    /**
     * The value is greater than a test value
     * EXAMPLE: `x` > "y"
     */
    const GT = 'gt';

    /**
     * The value is greater than or equal to a test value
     * EXAMPLE: `x` >= "y"
     */
    const GTE = 'gte';

    /**
     * The value is less than a test value
     * EXAMPLE: `x` < "y"
     */
    const LT = 'lt';

    /**
     * The value is less than or equal to a test value
     * EXAMPLE: `x` <= "y"
     */
    const LTE = 'lte';

    /**
     * The value is in a set of of test values
     * EXAMPLE: `x` IN (y1, y2, y3)
     */
    const IN = 'in';

    /**
     * The value is not in a set of test values
     * EXAMPLE: `x` NOT IN (y1, y2, y3)
     */
    const NIN = 'nin';

    /**
     * A value is between two values inclusively (GTE <=> LTE)
     * EXAMPLE: `x` >= "y1" AND `x` <= "y2"
     */
    const BETWEEN = 'between';

    /**
     * Values that are empty or null
     * EXAMPLE: `x` IS NULL OR `x` == ""
     */
    const EMPTY = 'empty';

    /**
     * Values that are not empty or not null
     * EXAMPLE: `x` IS NOT NULL AND `x` != ""
     */
    const NOT_EMPTY = 'nempty';

    /**
     * The field this criteria should match.
     *
     * @var string
     */
    protected string $key;

    /**
     * The operator used to test the key against the test value.
     *
     * @var string
     */
    protected string $operator;

    /**
     * The test data to evaluate the criteria.
     *
     * @var string
     */
    protected string $value;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param  string $key
     * @return Criterion
     */
    public function setKey(string $key): Criterion
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * @param  string $operator
     * @return Criterion
     */
    public function setOperator(string $operator): Criterion
    {
        $this->operator = $operator;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get a single value from the array of values.
     *
     * @param  int $idx
     * @return string
     */
    public function getValueByIndex(int $idx): string
    {
        $arr = $this->getValueArray();
        return $arr[$idx];
    }

    /**
     * A helper method to get a value as an array.
     *
     * @return array
     */
    public function getValueArray(): array
    {
        return explode(self::DELIMITER, $this->value);
    }

    /**
     * @param  string $value
     * @return Criterion
     */
    public function setValue(string $value): Criterion
    {
        $this->value = $value;
        return $this;
    }
}
