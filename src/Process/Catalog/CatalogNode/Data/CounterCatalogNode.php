<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Data;

use Feral\Core\Process\Attributes\ContextConfigurationDescription;
use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;


/**
 * A counter node which increments a value every time the
 * node is processed.
 */
#[ContextConfigurationDescription]
class CounterCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'counter';
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodeKey(): string
    {
        return 'counter';
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Counter';
    }

    /**
     * @inheritDoc
     */
    public function getGroup(): string
    {
        return 'Data';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'A counter that ticks every time the node is processed.';
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return [];
    }
}
