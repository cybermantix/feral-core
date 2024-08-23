<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Comparator;

use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\NodeCode\Flow\ContextValueComparatorNodeCode;
use Feral\Core\Utility\Filter\Criterion;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Check a context value and return true if it's zero
 * or false otherwise
 */
class EqualsZeroCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'equals_zero';
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
        return 'Equals Zero';
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
        return 'Check if a context value is zero.';
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
            ContextValueComparatorNodeCode::OPERATOR => Criterion::EQ
        ];
    }

    /**
     * @inheritDoc
     */
    public function getConfigurationDescriptions(): array
    {
        return [
            (new StringConfigurationDescription())
                ->setKey(ContextValueComparatorNodeCode::CONTEXT_PATH)
                ->setName('Data Path')
                ->setDescription('The context path to get the value being tested.'),
        ];
    }
}
