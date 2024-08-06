<?php

namespace Feral\Core\Tests\Utility\Filter;

use Feral\Core\Utility\Filter\Exception\FilterParserException;
use Feral\Core\Utility\Filter\OrderStringParser;
use Feral\Core\Utility\Filter\OrderStringParserInterface;
use Feral\Core\Utility\Filter\PeriscopeNotationParser;
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
