<?php

namespace Nodez\Core\Process\NodeCode\NodeCodeSource;

use Nodez\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;

/**
 * A catalog source which is contains an array of catalogNode objects.
 */
class NodeCodeSource implements NodeCodeSourceInterface
{
    public function __construct(
        /**
         * @var CatalogNodeInterface[]
         */
        private array $nodeCodes = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodes(): array
    {
        return $this->nodeCodes;
    }
}
