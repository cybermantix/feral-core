<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Context;

use Feral\Core\Process\Attributes\ContextConfigurationDescription;
use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\NodeCode\Data\SetContextValueNodeCode;

/**
 * Sets a value into the context at a certain key.
 */
#[ContextConfigurationDescription]
#[StringConfigurationDescription(
    key: SetContextValueNodeCode::VALUE,
    name: 'Value',
    description: 'The value to set in the context.'
)]
#[StringConfigurationDescription(
    key: SetContextValueNodeCode::VALUE_TYPE,
    name: 'Value Type',
    description: 'The type of variable to set into the context.',
    options: [
        SetContextValueNodeCode::OPTION_STRING,
        SetContextValueNodeCode::OPTION_INT,
        SetContextValueNodeCode::OPTION_FLOAT
    ]
)]
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
}
