<?php

namespace NoLoCo\Core\Process\Catalog\CatalogNode\Comparator;

use JetBrains\PhpStorm\ArrayShape;
use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use NoLoCo\Core\Process\NodeCode\Flow\ContextValueComparatorNodeCode;
use NoLoCo\Core\Utility\Filter\Criterion;

/**
 * Check a context value and return true if it's less than
 * zero or false if it's zero or greater than zero.
 */
class LessThanZeroCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'less_than_zero';
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodeKey(): string
    {
        return 'context_value_comparator';
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Less Than Zero';
    }

    /**
     * @inheritDoc
     */
    public function getGroup(): string
    {
        return 'Comparator';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Check if a context value is less than zero.';
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape(
        [
        ContextValueComparatorNodeCode::TEST_VALUE => "int",
        ContextValueComparatorNodeCode::OPERATOR => "string"
        ]
    )]
    public function getConfiguration(): array
    {
        return [
            ContextValueComparatorNodeCode::TEST_VALUE => 0,
            ContextValueComparatorNodeCode::OPERATOR => Criterion::LT
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
