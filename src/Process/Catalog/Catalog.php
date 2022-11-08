<?php

namespace NoLoCo\Core\Process\Catalog;

use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use NoLoCo\Core\Process\Catalog\CatalogSource\CatalogSourceInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class Catalog implements CatalogInterface
{
    private array $catalogNodes;

    public function __construct(
        #[TaggedIterator('noloco.catalog_source')] iterable $sources
    ) {
        /** @var CatalogSourceInterface $source */
        foreach ($sources as $source) {
            foreach ($source->getCatalogNodes() as $node) {
                $key = $node->getKey();
                if (!empty($key)) {
                    $this->catalogNodes[$key] = $node;
                }
            }
        }
    }
    /**
     * @inheritDoc
     */
    public function getCatalogNode(string $key): CatalogNodeInterface
    {
        return $this->catalogNodes[$key];
    }

    /**
     * @inheritDoc
     */
    public function getCatalogNodes(): array
    {
        return $this->catalogNodes;
    }
}