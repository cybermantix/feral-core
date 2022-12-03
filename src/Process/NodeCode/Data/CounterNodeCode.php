<?php

namespace Nodez\Core\Process\NodeCode\Data;

use Exception;
use Nodez\Core\Process\Configuration\ConfigurationManager;
use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\Exception\MissingConfigurationValueException;
use Nodez\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Nodez\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use Nodez\Core\Process\NodeCode\Configuration\Description\StringArrayConfigurationDescription;
use Nodez\Core\Process\NodeCode\NodeCodeInterface;
use Nodez\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Nodez\Core\Process\NodeCode\Traits\ConfigurationValueTrait;
use Nodez\Core\Process\NodeCode\Traits\ContextMutationTrait;
use Nodez\Core\Process\NodeCode\Traits\ContextValueTrait;
use Nodez\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use Nodez\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Nodez\Core\Process\NodeCode\Traits\OkResultsTrait;
use Nodez\Core\Process\NodeCode\Traits\ResultsTrait;
use Nodez\Core\Process\Result\ResultInterface;
use Nodez\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use Nodez\Core\Utility\Search\DataPathReader;
use Nodez\Core\Utility\Search\DataPathReaderInterface;
use Nodez\Core\Utility\Search\DataPathWriter;

/**
 * Create a counter that ticks every pass through the
 * node.
 *
 * Configuration Keys
 *  context_path - The path in the context
 *
 * @package Nodez\Core\Process\Node\Data
 */
class CounterNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        EmptyConfigurationDescriptionTrait,
        ContextValueTrait,
        ContextMutationTrait,
        OkResultsTrait;

    const DEFAULT_CONTEXT_PATH = '_counter';

    const KEY = 'counter';

    const NAME = 'Counter';

    const DESCRIPTION = 'A counter that ticks on every pass in the node.';

    public const CONTEXT_PATH = 'context_path';

    public function __construct(
        DataPathReaderInterface $dataPathReader = new DataPathReader(),
        DataPathWriter $dataPathWriter = new DataPathWriter(),
        ConfigurationManager $configurationManager = new ConfigurationManager()
    ) {
        $this->setMeta(
            self::KEY,
            self::NAME,
            self::DESCRIPTION,
            NodeCodeCategoryInterface::DATA
        )
            ->setConfigurationManager($configurationManager)
            ->setDataPathWriter($dataPathWriter)
            ->setDataPathReader($dataPathReader);
    }


    /**
     * @return ConfigurationDescriptionInterface[]
     */
    public function getConfigurationDescriptions(): array
    {
        return [
            (new StringArrayConfigurationDescription())
                ->setKey(self::CONTEXT_PATH)
                ->setName('Context Path')
                ->setDescription('The context path where the counter is held.')
        ];
    }

    /**
     * @inheritDoc
     * @throws     MissingConfigurationValueException|UnknownComparatorException
     * @throws     Exception
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $contextPath = $this->getRequiredConfigurationValue(self::CONTEXT_PATH, self::DEFAULT_CONTEXT_PATH);
        $counter = $this->getValueFromContext($contextPath, $context);
        if (!$counter) {
            $counter = 0;
        }
        $counter++;
        $this->setValueInContext($contextPath, $counter, $context);

        return $this->result(
            ResultInterface::OK,
            'Changed the counter to %u.',
            [$counter]
        );
    }
}
