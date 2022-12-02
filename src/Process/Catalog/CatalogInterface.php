<?php

namespace NoLoCo\Core\Process\Catalog;

use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;

/**
 * The catalog is a list of catalog nodes available to be
 * added to a process.
 */
interface CatalogInterface
{
    /**
     * Get a single catalog node by it's key
     *
     * @param  string $key
     * @return CatalogNodeInterface
     */
    public function getCatalogNode(string $key): CatalogNodeInterface;

    /**
     * Get all of the catalog nodes available.
     *
     * @return CatalogNodeInterface[]
     */
    public function getCatalogNodes(): array;
}
