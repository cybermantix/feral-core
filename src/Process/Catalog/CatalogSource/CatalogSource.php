<?php

namespace Nodez\Core\Process\Catalog\CatalogSource;

use Nodez\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;

/**
 * A catalog source which is contains an array of catalogNode objects.
 */
class CatalogSource implements CatalogSourceInterface
{
    public function __construct(
        /**
         * @var CatalogNodeInterface[]
         */
        private array $catalogNodes = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getCatalogNodes(): array
    {
        return $this->catalogNodes;
    }
}
