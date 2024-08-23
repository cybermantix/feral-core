<?php

namespace Feral\Core\Process\Attributes;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\ResultInterface;

/**
 * @see ResultDescriptionInterface
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class FalseResultDescription extends AbstractResultDescription
{

    public function __construct(
        /**
         * The description of the result
         */
        string $description = 'The result of the test was false.'
    ){
        parent::__construct(ResultInterface::FALSE, $description);
    }
}