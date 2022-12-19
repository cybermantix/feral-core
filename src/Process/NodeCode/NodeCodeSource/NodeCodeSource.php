<?php

namespace Feral\Core\Process\NodeCode\NodeCodeSource;

use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;

/**
 * A catalog source which is contains an array of catalogNode objects.
 */
class NodeCodeSource implements NodeCodeSourceInterface
{
    public function __construct(
        /**
         * @var CatalogNodeInterface[]
         */
        private iterable $nodeCodes = []
    ) {
        $this->nodeCodes = iterator_to_array($this->nodeCodes);
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodes(): array
    {
        return $this->nodeCodes;
    }
}
