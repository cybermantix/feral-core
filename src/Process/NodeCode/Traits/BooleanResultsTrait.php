<?php

namespace Feral\Core\Process\NodeCode\Traits;

use Feral\Core\Process\Result\Description\ResultDescription;
use Feral\Core\Process\Result\ResultInterface;

/**
 * A trait to return the result descriptions for a
 * node that only returns true or false.
 */
trait BooleanResultsTrait
{
    public function getResultDescriptions(): array
    {
        return [
            (new ResultDescription())
                ->setResult(ResultInterface::TRUE)
                ->setDescription('The node test was true.'),
            (new ResultDescription())
                ->setResult(ResultInterface::FALSE)
                ->setDescription('The node test was false.')
        ];
    }
}