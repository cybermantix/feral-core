<?php

namespace Feral\Core\Process\Catalog\CatalogNode\Flow;

use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Catalog\CatalogNode\CatalogNodeInterface;
use Feral\Core\Process\NodeCode\Flow\ThrowExceptionNodeCode;

/**
 * Throw an exception that will be handled like any other exception in the
 * system.
 */
class ThrowCatalogNode implements CatalogNodeInterface
{
    /**
     * @inheritDoc
     */
    public function getKey(): string
    {
        return 'throw';
    }

    /**
     * @inheritDoc
     */
    public function getNodeCodeKey(): string
    {
        return 'throw_exception';
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return 'Throw Exception';
    }

    /**
     * @inheritDoc
     */
    public function getGroup(): string
    {
        return 'Flow';
    }

    /**
     * @inheritDoc
     */
    public function getDescription(): string
    {
        return 'Throw an exception.';
    }

    /**
     * @inheritDoc
     */
    public function getConfiguration(): array
    {
        return [
            new StringConfigurationDescription(ThrowExceptionNodeCode::MESSAGE, 'Message', 'Message')
        ];
    }
}
