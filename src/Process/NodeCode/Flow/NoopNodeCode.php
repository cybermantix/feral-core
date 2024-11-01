<?php

namespace Feral\Core\Process\NodeCode\Flow;

use Feral\Core\Process\Attributes\CatalogNodeDecorator;
use Feral\Core\Process\Attributes\OkResultDescription;
use Feral\Core\Process\Attributes\ResultDescription;
use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Filter\Criterion;

#[StringConfigurationDescription(
    key: self::CONTEXT_PATH,
    name: 'Context Path',
    description: 'The context path to return in the result'
)]/**
 * Class ComparatorNode
 * Start the process by returning the OK status.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
 */
#[CatalogNodeDecorator(
    key:'noop',
    name: 'No Operation',
    group: 'Flow',
    description: 'Do nothing and return OK. Use as a placeholder')]
#[OkResultDescription(description: 'Return OK')]
class NoopNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait;

    const KEY = 'noop';
    const NAME = 'No Operation';
    const DESCRIPTION = 'A placeholder node.';

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
        return $this->result(ResultInterface::OK, 'Return OK.');
    }
}
