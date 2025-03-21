<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Calculation;

use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Attributes\StringArrayConfigurationDescription;
use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\NodeCode\Data\CalculationNodeCode;

/**
 * Raise the x value to the power of y
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
class PowerCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'power';
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
        return 'Power';
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
        return 'Raise the value from the x path to the power of y.';
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return [
            CalculationNodeCode::OPERATION => CalculationNodeCode::POWER
        ];
    }
}
