<?php

namespace Nodez\Core\Tests\Utility\Filter;

use Nodez\Core\Utility\Filter\Exception\FilterParserException;
use Nodez\Core\Utility\Filter\OrderStringParser;
use Nodez\Core\Utility\Filter\OrderStringParserInterface;
use Nodez\Core\Utility\Filter\PeriscopeNotationParser;
use PHPUnit\Framework\TestCase;

class OrderParserTest extends TestCase
{
    protected OrderStringParserInterface $parser;

    protected function setUp(): void
    {
        $this->parser = new OrderStringParser(new PeriscopeNotationParser());
    }

    public function testParse()
    {
        $order = $this->parser->parse('key((DESC))');
        $this->assertEquals('key', $order->getKey());
        $this->assertEquals('DESC', $order->getDirection());
    }

    public function testParseLeftException()
    {
        $this->expectException(FilterParserException::class);
        $this->parser->parse('key((test))');
    }
}
