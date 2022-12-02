<?php

namespace NoLoCo\Core\Tests\Process\Catalog;

use NoLoCo\Core\Process\Catalog\Catalog;
use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use NoLoCo\Core\Process\Catalog\CatalogSource\CatalogSourceInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \NoLoCo\Core\Process\Catalog\Catalog
 */
class CatalogTest extends TestCase
{
    protected Catalog $catalog;

    protected function setUp(): void
    {
        $mockSource = $this->createMock(CatalogSourceInterface::class);
        $mockNode = $this->createMock(CatalogNodeInterface::class);
        $mockNode->method('getKey')->willReturn('one');
        $mockSource->method('getCatalogNodes')->willReturn([$mockNode]);
        $this->catalog = new Catalog([
            $mockSource
        ]);
    }

    public function testGetCatalogNode()
    {
        $node = $this->catalog->getCatalogNode('one');
        $this->assertEquals('one', $node->getKey());
    }

    public function testGetCatalogNodes()
    {
        $nodes = $this->catalog->getCatalogNodes();
        $this->assertCount(1, $nodes);
    }
}
