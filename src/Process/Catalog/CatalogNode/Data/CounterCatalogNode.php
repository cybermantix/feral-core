<?php

namespace NoLoCo\Core\Process\Catalog\CatalogNode\Data;

use JetBrains\PhpStorm\ArrayShape;
use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use NoLoCo\Core\Process\NodeCode\Data\LogNodeCode;
use Psr\Log\LogLevel;

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
    #[ArrayShape([LogNodeCode::LEVEL => "string"])]
    public function getConfiguration(): array
    {
        return [];
    }
}