<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Calculation;

use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use Feral\Core\Process\NodeCode\Configuration\Description\StringConfigurationDescription;
use Feral\Core\Process\NodeCode\Data\RandomValueNodeCode;

/**
 * Add a random number between zero and one to a context node
 */
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
    /**
     * @return ConfigurationDescriptionInterface[]
     */
    public function getConfigurationDescriptions(): array
    {
        return [
            (new StringConfigurationDescription())
                ->setKey(RandomValueNodeCode::CONTEXT_PATH)
                ->setName('Context Path')
                ->setDescription('The context path to set the random number'),
        ];
    }
}
