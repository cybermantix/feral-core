<?php

namespace NoLoCo\Core\Process\Catalog\CatalogSource;

use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;

/**
 * A catalog source provides CatalogNodes to a catalog.
 */
interface CatalogSourceInterface
{
    /**
     * @return CatalogNodeInterface[]
     */
    public function getCatalogNodes(): array;
}