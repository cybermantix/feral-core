<?php

namespace Feral\Core\Process\NodeCode\Traits;

use Feral\Core\Process\Result\Description\ResultDescription;
use Feral\Core\Process\Result\ResultInterface;

/**
 * A trait to return the result descriptions for a simple
 * node that only returns TRUE or FALSE
 */
trait TrueFalseResultsTrait
{
    /**
     * @inheritDoc
     */
    public function getResultDescriptions(): array
    {
        return [
            (new ResultDescription())
                ->setResult(ResultInterface::TRUE)
                ->setDescription('The node processed to be truthy.'),
            (new ResultDescription())
                ->setResult(ResultInterface::FALSE)
                ->setDescription('The node processed to be false.'),
        ];
    }
}