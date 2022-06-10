<?php

namespace NoLoCo\Core\Tests\Utility\Filter;

use NoLoCo\Core\Utility\Filter\Exception\FilterParserException;
use NoLoCo\Core\Utility\Filter\OrderStringParser;
use NoLoCo\Core\Utility\Filter\OrderStringParserInterface;
use NoLoCo\Core\Utility\Filter\PeriscopeNotationParser;
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
