<?php

namespace NoLoCo\Core\Process\NodeCode\Data;

use Exception;
use NoLoCo\Core\Process\Configuration\ConfigurationManager;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Exception\MissingConfigurationValueException;
use NoLoCo\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\StringArrayConfigurationDescription;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Process\NodeCode\Traits\ConfigurationTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ConfigurationValueTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ContextMutationTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ContextValueTrait;
use NoLoCo\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use NoLoCo\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use NoLoCo\Core\Process\NodeCode\Traits\OkResultsTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ResultsTrait;
use NoLoCo\Core\Process\Result\ResultInterface;
use NoLoCo\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use NoLoCo\Core\Utility\Search\DataPathReader;
use NoLoCo\Core\Utility\Search\DataPathReaderInterface;
use NoLoCo\Core\Utility\Search\DataPathWriter;

/**
 * Create a counter that ticks every pass through the
 * node.
 *
 * Configuration Keys
 *  context_path - The path in the context
 *
 * @package NoLoCo\Core\Process\Node\Data
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
