<?php

namespace Feral\Core\Process\Catalog;

use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\Catalog\CatalogSource\CatalogSourceInterface;
use Feral\Core\Process\Exception\ProcessException;

/**
 * The catalog is a container that holds all of the catalog
 * nodes and the nodes can be accessed and returned by the catalog
 * node's key.
 */
class Catalog implements CatalogInterface
{
    /**
     * The nodes stored in this catalog.
     * @var array
     */
    private array $catalogNodes = [];

    /**
     * @param iterable|CatalogSourceInterface[] $sources
     * @throws ProcessException
     */
    public function __construct(iterable $sources = [])
    {
        /**
         * @var CatalogSourceInterface $source
         */
        foreach ($sources as $source) {
            if (!is_a($source, CatalogSourceInterface::class)) {
                throw new ProcessException('The Catalog requires CatalogSourceInterface objects.');
            }
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
