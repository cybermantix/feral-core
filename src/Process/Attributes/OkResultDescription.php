<?php

namespace Feral\Core\Process\Attributes;
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\ResultInterface;

/**
 * @see ResultDescriptionInterface
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS)]
class OkResultDescription extends AbstractResultDescription
{

    public function __construct(
        /**
         * The description of the result
         */
        string $description = 'The node processing was successful.'
    ){
        parent::__construct(ResultInterface::OK, $description);
    }
}