<?php

namespace Nodez\Core\Process\Catalog\CatalogNode\Log;

use JetBrains\PhpStorm\ArrayShape;
use Nodez\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Nodez\Core\Process\NodeCode\Data\LogNodeCode;
use Psr\Log\LogLevel;

/**
 * A catalog node which logs WARNING statements to the master debugger.
 *
 * @see LogNodeCode
 */
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
        return 'Log';
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
    /**
     * @inheritDoc
     */
    public function getConfigurationDescriptions(): array
    {
        return [];
    }
}
