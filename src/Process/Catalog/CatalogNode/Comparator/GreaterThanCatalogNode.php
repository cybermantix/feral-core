<?php

namespace NoLoCo\Core\Process\Catalog\CatalogNode\Comparator;

use JetBrains\PhpStorm\ArrayShape;
use NoLoCo\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use NoLoCo\Core\Process\NodeCode\Flow\ContextValueComparatorNodeCode;
use NoLoCo\Core\Utility\Filter\Criterion;

/**
 * Check if a conteext value is greater than a valuee
 */
class GreaterThanCatalogNode implements CatalogNodeInterface
{

    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'greater_than';
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
        return 'Greater Than';
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
        return 'Check if a context value is greater than a configuration value.';
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape([ContextValueComparatorNodeCode::OPERATOR => "string"])]
    public function getConfiguration(): array
    {
        return [
            ContextValueComparatorNodeCode::OPERATOR => Criterion::GT
        ];
    }
}