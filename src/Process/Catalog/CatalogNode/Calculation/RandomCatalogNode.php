<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Calculation;

use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Attributes\ContextConfigurationDescription;
use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\NodeCode\Data\RandomValueNodeCode;

/**
 * Add a random number between zero and one to a context node
 */
#[ContextConfigurationDescription]
class RandomCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'random';
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
        return 'Random';
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
        return 'Add a random value to the context';
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return [];
    }
}
