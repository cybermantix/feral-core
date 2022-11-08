<?php

namespace NoLoCo\Core\Process\NodeCode\NodeCodeSource;

use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;

/**
 * A catalog source provides CatalogNodes to a catalog.
 */
interface NodeCodeSourceInterface
{
    /**
     * @return CatalogNodeInterface[]
     */
    public function getNodeCodes(): array;
}