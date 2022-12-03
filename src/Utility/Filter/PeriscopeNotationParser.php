<?php


namespace Nodez\Core\Utility\Filter;


use Nodez\Core\Utility\Filter\Exception\FilterParserException;

/**
 * Class PeriscopeNotationParser
 * The Periscope
 *
 * ┌──────────────────────────────────────────────────────────────────────────────────┐
 * │ ___  ____ ____ _ ____ ____ ____ ___  ____    _  _ ____ ___ ____ ___ _ ____ _  _  │
 * │ |__] |___ |__/ | [__  |    |  | |__] |___    |\ | |  |  |  |__|  |  | |  | |\ |  │
 * │ |    |___ |  \ | ___] |___ |__| |    |___    | \| |__|  |  |  |  |  | |__| | \|  │
 * │                                                                                  │
 * └──────────────────────────────────────────────────────────────────────────────────┘
 *
 * TRIPARTITE (equals, in, contains)
 *                  .───────.
 *                ,'         `.
 * ┌───────────┐ ╱             ╲┌───────────┐
 * │    Key    │;   Operator    │   Value   │
 * └───────────┘:               └───────────┘
 *                ╲           ╱
 *                   `─────'
 *
 * BIPARTITE (empty, not empty)
 *                  .───────.
 *                ,'         `.
 * ┌───────────┐ ╱             ╲
 * │    Key    │;    Operator   │
 * └───────────┘:               └
 *                ╲           ╱
 *                   `─────'
 *
 * @package Nodez\Core\Utility\Filter
 */
class PeriscopeNotationParser implements PeriscopeNotationParserInterface
{
    /**
     * The property/operator/value left side delimiter
     */
    const LEFT_DELIMITER = '((';

    /**
     * The property/operator/value right side delimiter
     */
    const RIGHT_DELIMITER = '))';

    /**
     * Parse a string in periscope notation into three parts.
     *
     * @param  string $criterionString
     * @return array
     * @throws FilterParserException
     */
    public function parseTripartite(string $criterionString) : array
    {
        $leftLength = strlen(self::LEFT_DELIMITER);
        $rightLength = strlen(self::RIGHT_DELIMITER);
        list($leftPosition, $rightPosition) = $this->getPositions($criterionString);

        $key = trim(substr($criterionString, 0, $leftPosition));
        $operator = trim(
            substr(
                $criterionString,
                $leftPosition + $leftLength,
                $rightPosition - $leftPosition - $rightLength
            )
        );
        $value = trim(substr($criterionString, $rightPosition + strlen(self::RIGHT_DELIMITER)));
        return [$key, $operator, $value];
    }


    /**
     * Parse a string in periscope notation into two parts. The left side of the delimeter
     * and the value inside the delimeter are returned.
     *
     * @param  string $criterionString
     * @return array
     * @throws FilterParserException
     */
    public function parseLeftBipartite(string $criterionString) : array
    {
        $leftLength = strlen(self::LEFT_DELIMITER);
        $rightLength = strlen(self::RIGHT_DELIMITER);
        list($leftPosition, $rightPosition) = $this->getPositions($criterionString);

        $key = trim(substr($criterionString, 0, $leftPosition));
        $operator = trim(substr($criterionString, $leftPosition + $leftLength, -$rightLength));
        return [$key, $operator];
    }

    /**
     * Parse a string in periscope notation into three parts.
     *
     * @param  string $criterionString
     * @return array
     * @throws FilterParserException
     */
    public function parseRightBipartite(string $criterionString) : array
    {
        $leftLength = strlen(self::LEFT_DELIMITER);
        $rightLength = strlen(self::RIGHT_DELIMITER);
        list($leftPosition, $rightPosition) = $this->getPositions($criterionString);

        $operator = trim(
            substr(
                $criterionString,
                $leftPosition + $leftLength,
                $rightPosition - $leftPosition - $rightLength
            )
        );
        $value = trim(substr($criterionString, $rightPosition + strlen(self::RIGHT_DELIMITER)));
        return [$operator, $value];
    }

    /**
     * @param  string $criterionString
     * @return array
     * @throws FilterParserException
     */
    protected function getPositions(string $criterionString): array
    {
        $leftPosition = strpos($criterionString, self::LEFT_DELIMITER);
        $rightPosition = strpos($criterionString, self::RIGHT_DELIMITER);

        if ($leftPosition >= $rightPosition) {
            throw new FilterParserException(
                sprintf(
                    'The left "%d" position must be less than right "%d" position.',
                    $leftPosition,
                    $rightPosition
                )
            );
        }

        return [$leftPosition, $rightPosition];
    }
}
