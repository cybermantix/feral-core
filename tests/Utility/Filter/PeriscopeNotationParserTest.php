<?php

namespace Nodez\Core\Tests\Utility\Filter;

use Nodez\Core\Utility\Filter\Exception\FilterParserException;
use Nodez\Core\Utility\Filter\PeriscopeNotationParser;
use PHPUnit\Framework\TestCase;

class PeriscopeNotationParserTest extends TestCase
{

    /**
     * @throws FilterParserException
     */
    public function testParseTripartite()
    {
        $parser = new PeriscopeNotationParser();
        $data = $parser->parseTripartite('key((op))value');
        $this->assertCount(3, $data);
        $this->assertEquals('key', $data[0]);
        $this->assertEquals('op', $data[1]);
        $this->assertEquals('value', $data[2]);
    }

    /**
     * @throws FilterParserException
     */
    public function testParseLeftBipartite()
    {
        $parser = new PeriscopeNotationParser();
        $data = $parser->parseLeftBipartite('key((value))');
        $this->assertCount(2, $data);
        $this->assertEquals('key', $data[0]);
        $this->assertEquals('value', $data[1]);
    }

    /**
     * @throws FilterParserException
     */
    public function testParseRightBipartite()
    {
        $parser = new PeriscopeNotationParser();
        $data = $parser->parseRightBipartite('((operator))value');
        $this->assertCount(2, $data);
        $this->assertEquals('operator', $data[0]);
        $this->assertEquals('value', $data[1]);
    }

    public function testParseMixedException()
    {
        $parser = new PeriscopeNotationParser();
        $this->expectException(FilterParserException::class);
        $parser->parseTripartite('))op((value');
    }
}
