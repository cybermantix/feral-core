<?php

namespace NoLoCo\Core\Process\Catalog\CatalogNode\Flow;

use NoLoCo\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;

class StopCatalogNode implements \NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface
{

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'stop';
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodeKey(): string
    {
        return 'stop';
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Stop Processing';
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
        return 'The stop node will end a process.';
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return [];
    }
}