<?php

namespace Nodez\Core\Process\Catalog\CatalogNode\Calculation;

use Nodez\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Nodez\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use Nodez\Core\Process\NodeCode\Configuration\Description\StringArrayConfigurationDescription;
use Nodez\Core\Process\NodeCode\Data\CalculationNodeCode;

/**
 * Raise the x value to the power of y
 */
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
    /**
     * @return ConfigurationDescriptionInterface[]
     */
    public function getConfigurationDescriptions(): array
    {
        return [
            (new StringArrayConfigurationDescription())
                ->setKey(CalculationNodeCode::X_CONTEXT_PATH)
                ->setName('X Context Path')
                ->setDescription('The context path to the first variable, the left side, of the equation.'),
            (new StringArrayConfigurationDescription())
                ->setKey(CalculationNodeCode::Y_CONTEXT_PATH)
                ->setName('Y Context Path')
                ->setDescription('The context path to the second variable, the right side, of the equation.'),
            (new StringArrayConfigurationDescription())
                ->setKey(CalculationNodeCode::RESULT_PATH)
                ->setName('Result Context Path')
                ->setDescription('The context path to set the results of the operation.'),
        ];
    }
}
