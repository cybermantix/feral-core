<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Log;

use JetBrains\PhpStorm\ArrayShape;
use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\NodeCode\Data\LogNodeCode;
use Psr\Log\LogLevel;

/**
 * A catalog node which logs NOTICE statements to the master debugger.
 *
 * @see LogNodeCode
 */
class LogNoticeCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'log_notice';
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
        return 'Notice Logger';
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
        return 'Log a message with the notice level';
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([LogNodeCode::LEVEL => "string"])]
    public function getConfiguration(): array
    {
        return [
            LogNodeCode::LEVEL => LogLevel::NOTICE
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
