<?php

namespace NoLoCo\Core\Process\NodeCode\NodeCodeSource;

use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

/**
 * A catalog source which is contains an array of catalogNode objects.
 */
class TaggedNodeCodeSource implements NodeCodeSourceInterface
{
    private array $nodeCodes;
    public function __construct(
        #[TaggedIterator('noloco.node_code')] iterable $nodeCodes
    ){
        foreach ($nodeCodes as $nodeCode) {
            $this->nodeCodes[] = $nodeCode;
        }
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodes(): array
    {
        return $this->nodeCodes;
    }
}