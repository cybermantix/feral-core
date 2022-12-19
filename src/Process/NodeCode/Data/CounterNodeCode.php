<?php

namespace Feral\Core\Process\NodeCode\Data;

use Exception;
use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Exception\MissingConfigurationValueException;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use Feral\Core\Process\NodeCode\Configuration\Description\StringArrayConfigurationDescription;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Feral\Core\Process\NodeCode\Traits\ConfigurationValueTrait;
use Feral\Core\Process\NodeCode\Traits\ContextMutationTrait;
use Feral\Core\Process\NodeCode\Traits\ContextValueTrait;
use Feral\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\OkResultsTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use Feral\Core\Utility\Search\DataPathReader;
use Feral\Core\Utility\Search\DataPathReaderInterface;
use Feral\Core\Utility\Search\DataPathWriter;

/**
 * Create a counter that ticks every pass through the
 * node.
 *
 * Configuration Keys
 *  context_path - The path in the context
 *
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
