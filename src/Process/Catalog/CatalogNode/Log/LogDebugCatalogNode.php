<?php

namespace NoLoCo\Core\Process\Catalog\CatalogNode\Log;

use JetBrains\PhpStorm\ArrayShape;
use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use NoLoCo\Core\Process\NodeCode\Data\LogNodeCode;
use Psr\Log\LogLevel;

/**
 * A catalog node which logs DEBUG statements to the master debugger.
 *
 * @see LogNodeCode
 */
class LogDebugCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'log_debug';
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
        return 'Debug Logger';
    }

    /**
     * @inheritDoc
     */
    public function getGroup(): string
    {
        return 'Log';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Log a message with the debug level';
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([LogNodeCode::LEVEL => "string"])]
    public function getConfiguration(): array
    {
        return [
            LogNodeCode::LEVEL => LogLevel::DEBUG
        ];
    }
    /**
     * @inheritDoc
     */
    public function getConfigurationDescriptions(): array
    {
        return [];
    }
}
