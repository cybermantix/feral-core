<?php

namespace NoLoCo\Core\Process\NodeCode\Data;

use Exception;
use NoLoCo\Core\Process\Configuration\ConfigurationManager;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Exception\MissingConfigurationValueException;
use NoLoCo\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\StringArrayConfigurationDescription;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\StringConfigurationDescription;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Process\NodeCode\Traits\ConfigurationTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ConfigurationValueTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ContextMutationTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ContextValueTrait;
use NoLoCo\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use NoLoCo\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ResultsTrait;
use NoLoCo\Core\Process\Result\ResultInterface;
use NoLoCo\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use NoLoCo\Core\Utility\Search\DataPathWriter;
use NoLoCo\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * Set the value of a context key to a configured value. To set a deep reference
 * the parent object|array must exist.
 *
 * Configuration Keys
 *  table  - The associative array
 *
 * @package NoLoCo\Core\Process\Node\Data
 */
class SetContextTableNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait;
    use ResultsTrait;
    use ConfigurationTrait;
    use ConfigurationValueTrait;
    use EmptyConfigurationDescriptionTrait;
    use ContextValueTrait;
    use ContextMutationTrait;

    const KEY = 'set_context_table';

    const NAME = 'Set Context Table';

    const DESCRIPTION = 'Set multiple values in the context using a table (associative array)';

    public const TABLE = 'table';

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
        ];
    }

    /**
     * @inheritDoc
     * @throws     MissingConfigurationValueException|UnknownComparatorException
     * @throws     Exception
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $table = $this->getRequiredConfigurationValue(self::TABLE);

        foreach ($table as $key => $value) {
            if (str_starts_with($key, '_')) {
                throw new Exception('Keys may not start with underscores.');
            }
            $this->setValueInContext($key, $value, $context);
        }

        return $this->result(
            ResultInterface::OK,
            'Table of values set in the context.',
            []
        );
    }
}
