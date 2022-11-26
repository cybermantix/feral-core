<?php


namespace NoLoCo\Core\Utility\Filter;

/**
 * Interface CriterionStringParserInterface
 *
 * @package NoLoCo\Core\Utility\Filter
 */
interface CriterionStringParserInterface
{
    /**
     * Parse a string and return a criterion.
     *
     * @param  string $criterionString
     * @return Criterion
     */
    public function parse(string $criterionString) : Criterion;
}
