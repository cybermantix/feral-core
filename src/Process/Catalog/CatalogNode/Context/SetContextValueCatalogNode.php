<?php

namespace NoLoCo\Core\Process\Catalog\CatalogNode\Context;

use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\StringConfigurationDescription;
use NoLoCo\Core\Process\NodeCode\Data\SetContextValueNodeCode;

/**
 * Sets a value into the context at a certain key.
 */
class SetContextValueCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'set_context_value';
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodeKey(): string
    {
        return SetContextValueNodeCode::KEY;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Set Context Value';
    }

    /**
     * @inheritDoc
     */
    public function getGroup(): string
    {
        return 'Context';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Set a value in the context using a value and a path to the location.';
    }
    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return [];
    }
    /**
     * @inheritDoc
     */
    public function getConfigurationDescriptions(): array
    {
        return [
            (new StringConfigurationDescription())
                ->setKey(SetContextValueNodeCode::VALUE)
                ->setName('Value')
                ->setDescription('The value to set in the context.'),
            (new StringConfigurationDescription())
                ->setKey(SetContextValueNodeCode::CONTEXT_PATH)
                ->setName('Context Path')
                ->setDescription('The context path to set the value.'),
            (new StringConfigurationDescription())
                ->setKey(SetContextValueNodeCode::VALUE_TYPE)
                ->setName('Value Type')
                ->setDescription('The type of variable to set into the context.')
                ->setOptions(
                    [
                    SetContextValueNodeCode::OPTION_STRING,
                    SetContextValueNodeCode::OPTION_INT,
                    SetContextValueNodeCode::OPTION_FLOAT
                    ]
                )
        ];
    }
}
