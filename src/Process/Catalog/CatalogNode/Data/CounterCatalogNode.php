<?php

namespace NoLoCo\Core\Process\Catalog\CatalogNode\Data;

use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\StringArrayConfigurationDescription;
use NoLoCo\Core\Process\NodeCode\Data\CounterNodeCode;

/**
 * A counter node which increments a value every time the
 * node is processed.
 */
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
            (new StringArrayConfigurationDescription())
                ->setKey(CounterNodeCode::CONTEXT_PATH)
                ->setName('Context Path')
                ->setDescription('The context path where the counter is held.')
        ];
    }
}
