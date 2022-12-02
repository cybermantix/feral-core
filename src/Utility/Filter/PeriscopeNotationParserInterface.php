<?php


namespace NoLoCo\Core\Utility\Filter;

/**
 * Interface PeriscopeNotationParserInterface
 *
 * @package NoLoCo\Core\Utility\Filter
 */
interface PeriscopeNotationParserInterface
{
    /**
     * Parse a periscope notation string into it's three parts.
     *
     * @param  string $criterionString
     * @return array
     */
    public function parseTripartite(string $criterionString) : array;

    /**
     * Parse a periscope notation string into it's two parts.
     *
     * @param  string $criterionString
     * @return array
     */
    public function parseLeftBipartite(string $criterionString) : array;
}
