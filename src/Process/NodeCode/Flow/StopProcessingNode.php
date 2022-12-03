<?php

namespace Nodez\Core\Process\NodeCode\Flow;

use Nodez\Core\Process\Configuration\ConfigurationManager;
use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Nodez\Core\Process\NodeCode\NodeCodeInterface;
use Nodez\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Nodez\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use Nodez\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Nodez\Core\Process\NodeCode\Traits\ResultsTrait;
use Nodez\Core\Process\Result\Description\ResultDescription;
use Nodez\Core\Process\Result\ResultInterface;

/**
 * Class ComparatorNode
 * Stop the process by returning the stop status.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
 * @package Nodez\Core\Process\Node\FlowControl
 */
class StopProcessingNode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        EmptyConfigurationDescriptionTrait;

    const KEY = 'stop';

    const NAME = 'Stop Process';

    const DESCRIPTION = 'Stop the process.';

    public function __construct(
        ConfigurationManager $configurationManager = new ConfigurationManager()
    ) {
        $this->setMeta(
            self::KEY,
            self::NAME,
            self::DESCRIPTION,
            NodeCodeCategoryInterface::FLOW
        )->setConfigurationManager($configurationManager);
    }

    public function getResultDescriptions(): array
    {
        return [(new ResultDescription())
            ->setResult(ResultInterface::STOP)
            ->setDescription('The send the stop signal to the process engine.')];
    }

    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        return $this->result(ResultInterface::STOP, 'Stop processing.');
    }
}
