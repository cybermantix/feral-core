<?php


namespace NoLoCo\Core\Process\NodeCode\Flow;

use NoLoCo\Core\Process\Configuration\ConfigurationManager;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Process\NodeCode\Traits\ConfigurationTrait;
use NoLoCo\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use NoLoCo\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ResultsTrait;
use NoLoCo\Core\Process\Result\ResultInterface;

/**
 * Class ComparatorNode
 * Start the process by returning the OK status.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
 * @package NoLoCo\Core\Process\Node\FlowControl
 */
class StartProcessingNode implements NodeCodeInterface
{
    use NodeCodeMetaTrait, ResultsTrait, ConfigurationTrait, EmptyConfigurationDescriptionTrait;

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
