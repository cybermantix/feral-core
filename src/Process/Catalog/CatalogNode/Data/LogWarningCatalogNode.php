<?php

namespace NoLoCo\Core\Process\Catalog\CatalogNode\Data;

use JetBrains\PhpStorm\ArrayShape;
use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use NoLoCo\Core\Process\NodeCode\Data\LogNodeCode;
use Psr\Log\LogLevel;

class LogWarningCatalogNode implements CatalogNodeInterface
{

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'log_warning';
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodeKey(): string
    {
        return 'log';
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Warning Logger';
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
        return 'Log a message with the warning level';
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([LogNodeCode::LEVEL => "string"])]
    public function getConfiguration(): array
    {
        return [
            LogNodeCode::LEVEL => LogLevel::WARNING
        ];
    }
}