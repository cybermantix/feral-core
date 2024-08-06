<?php

namespace Feral\Core\Process\Catalog\CatalogSource;

use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;

/**
 * A catalog source which is contains an array of catalogNode objects.
 */
class CatalogSource implements CatalogSourceInterface
{
    public function __construct(
        /**
         * @var CatalogNodeInterface[]
         */
        private iterable $catalogNodes = []
    ) {
        $this->catalogNodes = iterator_to_array($this->catalogNodes);
    }

    /**
     * @inheritDoc
     */
    public function getCatalogNodes(): array
    {
        return $this->catalogNodes;
    }
}
