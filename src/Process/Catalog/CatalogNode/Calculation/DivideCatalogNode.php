<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Calculation;

use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Attributes\StringArrayConfigurationDescription;
use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\NodeCode\Data\CalculationNodeCode;

/**
 * Multiply the values of two variables stored in the context.
 */
#[StringConfigurationDescription(
    key: CalculationNodeCode::X_CONTEXT_PATH,
    name: 'X Context Path',
    description: 'The context path to the first variable, the left side, of the equation.'
)]
#[StringConfigurationDescription(
    key: CalculationNodeCode::Y_CONTEXT_PATH,
    name: 'Y Context Path',
    description: 'The context path to the second variable, the right side, of the equation.'
)]
#[StringConfigurationDescription(
    key: CalculationNodeCode::RESULT_PATH,
    name: 'Result Context Path',
    description: 'The context path to set the results of the operation.'
)]
class DivideCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'divide';
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodeKey(): string
    {
        return 'calculation';
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Divide';
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
        return 'Divide two values stored in the context.';
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return [
            CalculationNodeCode::OPERATION => CalculationNodeCode::DIVIDE
        ];
    }
}
