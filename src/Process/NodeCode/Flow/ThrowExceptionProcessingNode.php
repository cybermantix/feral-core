<?php

namespace Nodez\Core\Process\NodeCode\Flow;

use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\Exception\ProcessException;
use Nodez\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Nodez\Core\Process\NodeCode\NodeCodeInterface;
use Nodez\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Nodez\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use Nodez\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Nodez\Core\Process\NodeCode\Traits\ResultsTrait;
use Nodez\Core\Process\Result\ResultInterface;

/**
 * If an error is received then convert the error into an exception.
 *
 * Configuration Keys
 *  (No Configuration keys)
 */
class ThrowExceptionProcessingNode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        EmptyConfigurationDescriptionTrait;

    const KEY = 'throw_exception';

    const NAME = 'Throw Exception';

    const DESCRIPTION = 'Throw an exception in the process.';

    public function __construct()
    {
        $this->setMeta(
            self::KEY,
            self::NAME,
            self::DESCRIPTION,
            NodeCodeCategoryInterface::FLOW
        );
    }

    public function getResultDescriptions(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     * @throws     ProcessException
     */
    public function process(ContextInterface $context): ResultInterface
    {
        throw new ProcessException('An error occurred during a process. Please review the process logs.');
    }
}
