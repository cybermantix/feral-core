<?php


namespace NoLoCo\Core\Utility\Filter;


abstract class AbstractPeriscopeNotationParser
{
    /**
     * @var PeriscopeNotationParserInterface
     */
    protected PeriscopeNotationParserInterface $parser;

    /**
     * AbstractPeriscopeNotationParser constructor.
     * @param PeriscopeNotationParserInterface $parser
     */
    public function __construct(PeriscopeNotationParserInterface $parser)
    {
        $this->parser = $parser;
    }
}
