<?php

namespace Feral\Core\Tests\Process\Catalog\CatalogSource;

use Feral\Core\Process\Catalog\CatalogNode\CatalogNode;
use Feral\Core\Process\Catalog\CatalogSource\CatalogSource;
use PHPUnit\Framework\TestCase;

class ConfigurationCatalogSourceTest extends TestCase
{
    private CatalogSource $source;

    protected function setUp(): void
    {
        $this->source = new CatalogSource(new \ArrayIterator([
            (new CatalogNode())->setKey('one'),
            (new CatalogNode())->setKey('two')
        ]));
    }

    public function testGetCatalogNodes()
    {
        $this->assertEquals(2, count($this->source->getCatalogNodes()));
    }
}
