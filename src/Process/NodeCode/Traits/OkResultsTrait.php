<?php

namespace Nodez\Core\Process\NodeCode\Traits;

use Nodez\Core\Process\Result\Description\ResultDescription;
use Nodez\Core\Process\Result\ResultInterface;

/**
 * A trait to return the result descriptions for a simple
 * node that only returns the OK result.
 */
trait OkResultsTrait
{
    /**
     * @inheritDoc
     */
    public function getResultDescriptions(): array
    {
        return [(new ResultDescription())
            ->setResult(ResultInterface::OK)
            ->setDescription('The node processed as expected.')];
    }
}