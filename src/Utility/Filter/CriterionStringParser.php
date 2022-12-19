<?php


namespace Feral\Core\Utility\Filter;

use Feral\Core\Utility\Filter\Exception\FilterParserException;

/**
 * Class PeriscopeNotationParser
 *
 */
class CriterionStringParser extends AbstractPeriscopeNotationParser implements CriterionStringParserInterface
{

    /**
     * Parse a string in periscope notation into it's three parts then
     * create a Criterion object.
     *
     * @param  string $criterionString
     * @return Criterion
     * @throws FilterParserException
     */
    public function parse(string $criterionString) : Criterion
    {
        list($key, $operator, $value) = $this->parser->parseTripartite($criterionString);

        if (empty($key)) {
            throw new FilterParserException(
                sprintf(
                    'The key "%s" is invalid.',
                    $criterionString
                )
            );
        }
        if (empty($operator)) {
            throw new FilterParserException(
                sprintf(
                    'The operator "%s" is invalid.',
                    $criterionString
                )
            );
        }
        if (empty($value)) {
            $value = '';
        }
        return (new Criterion())
            ->setKey($key)
            ->setOperator($operator)
            ->setValue($value);
    }
}
