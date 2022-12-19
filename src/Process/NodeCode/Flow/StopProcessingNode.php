<?php

namespace Feral\Core\Process\NodeCode\Flow;

use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Feral\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\Description\ResultDescription;
use Feral\Core\Process\Result\ResultInterface;

/**
 * Class ComparatorNode
 * Stop the process by returning the stop status.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
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
