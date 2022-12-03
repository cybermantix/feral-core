<?php


namespace Nodez\Core\Utility\Filter;

use Nodez\Core\Utility\Filter\Exception\FilterParserException;

/**
 * Interface CriterionStringParserInterface
 *
 * @package Nodez\Core\Utility\Filter
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
