<?php

namespace Feral\Core\Process\NodeCode\Flow;

use Feral\Core\Process\Attributes\OkResultDescription;
use Feral\Core\Process\Attributes\ResultDescription;
use Feral\Core\Process\Attributes\StopResultDescription;
use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\ResultInterface;

/**
 * Class ComparatorNode
 * Stop the process by returning the stop status.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
 */
#[StopResultDescription]
class StopProcessingNode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait;

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

    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        return $this->result(ResultInterface::STOP, 'Stop processing.');
    }
}
