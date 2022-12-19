<?php


namespace Feral\Core\Utility\Filter;

/**
 * Interface CriterionStringParserInterface
 *
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
