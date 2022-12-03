<?php

namespace Nodez\Core\Process\NodeCode\Data;

use Exception;
use Nodez\Core\Process\Configuration\ConfigurationManager;
use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\Exception\MissingConfigurationValueException;
use Nodez\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Nodez\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use Nodez\Core\Process\NodeCode\Configuration\Description\StringArrayConfigurationDescription;
use Nodez\Core\Process\NodeCode\Configuration\Description\StringConfigurationDescription;
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
use Nodez\Core\Utility\Search\DataPathReaderInterface;
use Nodez\Core\Utility\Search\DataPathWriter;

/**
 * Set the value of a context key to a configured value. To set a deep reference
 * the parent object|array must exist.
 *
 * Configuration Keys
 *  table  - The associative array
 *
 * @package Nodez\Core\Process\Node\Data
 */
class SetContextTableNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        EmptyConfigurationDescriptionTrait,
        ContextValueTrait,
        ContextMutationTrait,
        OkResultsTrait;

    const KEY = 'set_context_table';

    const NAME = 'Set Context Table';

    const DESCRIPTION = 'Set multiple values in the context using a table (associative array)';

    public const TABLE = 'table';

    public const CONTEXT_PATH = 'context_path';

    public function __construct(
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
            ->setDataPathWriter($dataPathWriter);
    }


    /**
     * @return ConfigurationDescriptionInterface[]
     */
    public function getConfigurationDescriptions(): array
    {
        return [
            (new StringArrayConfigurationDescription())
                ->setKey(self::TABLE)
                ->setName('Table')
                ->setDescription('Set multiple values in the context.'),
            (new StringConfigurationDescription())
                ->setKey(self::CONTEXT_PATH)
                ->setName('Context Path')
                ->setDescription('The optional context path to the parent where the table of values will be written.'),
        ];
    }

    /**
     * @inheritDoc
     * @throws     MissingConfigurationValueException
     * @throws     Exception
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $table = $this->getRequiredArrayConfigurationValue(self::TABLE);
        $contextPath = $this->getRequiredConfigurationValue(self::CONTEXT_PATH, '');
        if (!empty($contextPath)) {
            $contextPath .= DataPathReaderInterface::DEFAULT_DELIMITER;
        }
        foreach ($table as $key => $value) {
            $path = $contextPath . $key;
            $this->setValueInContext($path, $value, $context);
        }

        return $this->result(
            ResultInterface::OK,
            'Table of values set in the context.',
            []
        );
    }
}
