<?php

namespace Feral\Core\Process\NodeCode\NodeCodeSource;

use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;

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
