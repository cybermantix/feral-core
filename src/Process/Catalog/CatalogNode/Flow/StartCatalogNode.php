<?php

namespace NoLoCo\Core\Process\Catalog\CatalogNode\Flow;

use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;

/**
 * The first node in a process. This node will have the result
 * of "OK".
 */
class StartCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'start';
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodeKey(): string
    {
        return 'start';
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Start Processing';
    }

    /**
     * @inheritDoc
     */
    public function getGroup(): string
    {
        return 'Flow';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'The start node will start a process and return an OK result.';
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return [];
    }
    /**
     * @inheritDoc
     */
    public function getConfigurationDescriptions(): array
    {
        return [];
    }
}
