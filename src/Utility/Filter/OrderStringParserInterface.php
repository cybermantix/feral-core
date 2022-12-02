<?php


namespace NoLoCo\Core\Utility\Filter;

use NoLoCo\Core\Utility\Filter\Exception\FilterParserException;

/**
 * Interface CriterionStringParserInterface
 *
 * @package NoLoCo\Core\Utility\Filter
 */
interface OrderStringParserInterface
{
    /**
     * Parse a string and return a criterion.
     *
     * @param  string $orderString
     * @return Order
     * @throws FilterParserException
     */
    public function parse(string $orderString) : Order;
}
