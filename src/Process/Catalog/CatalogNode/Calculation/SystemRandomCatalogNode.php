<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Calculation;

use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Attributes\ContextConfigurationDescription;
use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\NodeCode\Data\RandomValueNodeCode;

/**
 * Add a random number between zero and one to the _random context key
 */
#[ContextConfigurationDescription]
class SystemRandomCatalogNode implements CatalogNodeInterface
{
    const CONTEXT_PATH = '_random';

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'system_random';
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodeKey(): string
    {
        return 'random';
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'System Random';
    }

    /**
     * @inheritDoc
     */
    public function getGroup(): string
    {
        return 'Calculation';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Add a random value to the _random context key';
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return [
            RandomValueNodeCode::CONTEXT_PATH => self::CONTEXT_PATH
        ];
    }
}
