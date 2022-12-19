<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Log;

use JetBrains\PhpStorm\ArrayShape;
use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\NodeCode\Data\LogNodeCode;
use Psr\Log\LogLevel;

/**
 * A catalog node which logs ERROR statements to the master debugger.
 *
 * @see LogNodeCode
 */
class LogErrorCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'log_error';
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
        return 'Error Logger';
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
        return 'Log a message with the error level';
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([LogNodeCode::LEVEL => "string"])]
    public function getConfiguration(): array
    {
        return [
            LogNodeCode::LEVEL => LogLevel::ERROR
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
