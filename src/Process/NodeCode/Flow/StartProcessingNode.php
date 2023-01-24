<?php

namespace Feral\Core\Process\NodeCode\Flow;

use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Feral\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\OkResultsTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\Description\ResultDescription;
use Feral\Core\Process\Result\ResultInterface;

/**
 * Class ComparatorNode
 * Start the process by returning the OK status.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
 */
class StartProcessingNode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        EmptyConfigurationDescriptionTrait,
        OkResultsTrait;

    const KEY = 'start';
    const NAME = 'Start Process';
    const DESCRIPTION = 'The node that starts a process.';

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

    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        return $this->result(ResultInterface::OK, 'Start processing.');
    }
}
