<?php

namespace Nodez\Core\Process\NodeCode\Flow;

use Nodez\Core\Process\Configuration\ConfigurationManager;
use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Nodez\Core\Process\NodeCode\NodeCodeInterface;
use Nodez\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Nodez\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use Nodez\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Nodez\Core\Process\NodeCode\Traits\OkResultsTrait;
use Nodez\Core\Process\NodeCode\Traits\ResultsTrait;
use Nodez\Core\Process\Result\Description\ResultDescription;
use Nodez\Core\Process\Result\ResultInterface;

/**
 * Class ComparatorNode
 * Start the process by returning the OK status.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
 * @package Nodez\Core\Process\Node\FlowControl
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
