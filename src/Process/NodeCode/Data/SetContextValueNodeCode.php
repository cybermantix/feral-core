<?php


namespace NoLoCo\Core\Process\NodeCode\Data;

use Exception;
use NoLoCo\Core\Process\Configuration\ConfigurationManager;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Exception\MissingConfigurationValueException;
use NoLoCo\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
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
 *  value  - The value added to the context
 *  context_path - The key in the context that will be set
 *  value_type - The type of var to place into the context
 *
 * @package NoLoCo\Core\Process\Node\Data
 */
class SetContextValueNodeCode implements NodeCodeInterface {

    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        EmptyConfigurationDescriptionTrait,
        ContextValueTrait,
        ContextMutationTrait;

    const OPTION_STRING = 'string';

    const OPTION_INT = 'int';

    const OPTION_FLOAT = 'float';

    const KEY = 'set_context_value';

    const NAME = 'Set Data Value';

    const DESCRIPTION = 'Set the value of a context key';

    public const VALUE = 'value';

    public const CONTEXT_PATH = 'context_path';

    public const VALUE_TYPE = 'value_type';

    public function __construct(
        DataPathWriter $dataPathWriter = new DataPathWriter(),
        ConfigurationManager $configurationManager = new ConfigurationManager()
    ){
        $this->setMeta(
            self::KEY,
            self::NAME,
            self::DESCRIPTION,
            NodeCodeCategoryInterface::DATA)
            ->setConfigurationManager($configurationManager)
            ->setDataPathWriter($dataPathWriter);
    }


    /**
     * @return ConfigurationDescriptionInterface[]
     */
    public function getConfigurationDescriptions(): array
    {
        return [
            (new StringConfigurationDescription())
                ->setKey(self::VALUE)
                ->setName('Value')
                ->setDescription('The value to set in the context.'),
            (new StringConfigurationDescription())
                ->setKey(self::CONTEXT_PATH)
                ->setName('Context Path')
                ->setDescription('The context path to set the value.'),
            (new StringConfigurationDescription())
                ->setKey(self::VALUE_TYPE)
                ->setName('Value Type')
                ->setDescription('The type of variable to set into the context.')
                ->setOptions([
                    self::OPTION_STRING,
                    self::OPTION_INT,
                    self::OPTION_FLOAT
                ])
        ];
    }

    /**
     * @inheritDoc
     * @throws UnknownTypeException
     * @throws MissingConfigurationValueException|UnknownComparatorException
     * @throws Exception
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $valueType = $this->getRequiredConfigurationValue(self::VALUE_TYPE, self::OPTION_STRING);
        $value = $this->getRequiredConfigurationValue(self::VALUE);
        $contextPath = $this->getRequiredConfigurationValue(self::CONTEXT_PATH);

        $value = match ($valueType) {
            self::OPTION_STRING => (string)$value,
            self::OPTION_INT => (int)$value,
            self::OPTION_FLOAT => (float)$value,
            default => throw new Exception(sprintf('Unknown type "%s".', $valueType)),
        };

        $this->setValueInContext($contextPath, $value, $context);

        return $this->result(
            ResultInterface::OK,
            'Set value in context path "%s".',
            [$contextPath]
        );
    }
}