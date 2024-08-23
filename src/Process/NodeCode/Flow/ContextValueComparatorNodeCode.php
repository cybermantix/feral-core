<?php

namespace Feral\Core\Process\NodeCode\Flow;

use Feral\Core\Process\Attributes\CatalogNodeDecorator;
use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Attributes\ContextConfigurationDescription;
use Feral\Core\Process\Attributes\OkResultDescription;
use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Exception\MissingConfigurationValueException;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\NodeCode\Traits\BooleanResultsTrait;
use Feral\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Feral\Core\Process\NodeCode\Traits\ConfigurationValueTrait;
use Feral\Core\Process\NodeCode\Traits\ContextValueTrait;
use Feral\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Filter\Comparator\Comparator;
use Feral\Core\Utility\Filter\Comparator\ComparatorInterface;
use Feral\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use Feral\Core\Utility\Filter\Criterion;
use Feral\Core\Utility\Search\DataPathReader;
use Feral\Core\Utility\Search\DataPathReaderInterface;
use Feral\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * Class ComparatorNode
 * Test if a value in the context passes a test with an operator.
 * To see the list of available operators see \Feral\Core\Utility\Filter\Criterion
 *
 * Configuration Keys
 *  operator    - The operator used in the test
 *  test_value  - The value used to test the actual value in the context
 *  context_path - The key used to retrieve the actual value from the context
 *
 */
#[ContextConfigurationDescription]
#[StringConfigurationDescription(
    key: self::OPERATOR,
    name: 'Comparison Operator',
    description: 'The operator to compare the context value in the path to the value stored',
    options: [
        Criterion::EQ,
        Criterion::GT,
        Criterion::GTE,
        Criterion::LT,
        Criterion::LTE,
        Criterion::NOT,
        Criterion::CONTAINS,
        Criterion::IN,
        Criterion::NIN,
        Criterion::NOT_EMPTY
    ]
)]
#[StringConfigurationDescription(
    key: self::TEST_VALUE,
    name: 'Test Value',
    description: 'The value to compare the context value to.'
)]
#[OkResultDescription(description: 'The comparison was successful.')]
#[CatalogNodeDecorator(
    key:'is_zero',
    name: 'Is Zero',
    group: 'Flow',
    description: 'Compare if a context value is zero.',
    configuration: [self::OPERATOR => Criterion::EQ, self::TEST_VALUE => 0])]
#[CatalogNodeDecorator(
    key:'is_not_zero',
    name: 'Is Not Zero',
    group: 'Flow',
    description: 'Compare if a context value is not zero.',
    configuration: [self::OPERATOR => Criterion::NOT, self::TEST_VALUE => 0])]
#[CatalogNodeDecorator(
    key:'is_greater_than_zero',
    name: 'Is Greater Than Zero',
    group: 'Flow',
    description: 'Compare if a context value is greater than zero.',
    configuration: [self::OPERATOR => Criterion::GT, self::TEST_VALUE => 0])]
#[CatalogNodeDecorator(
    key:'is_greater_than_equal_zero',
    name: 'Is Greater Than or Equal to Zero',
    group: 'Flow',
    description: 'Compare if a context value is greater than or equal to zero.',
    configuration: [self::OPERATOR => Criterion::GTE, self::TEST_VALUE => 0])]
#[CatalogNodeDecorator(
    key:'is_less_than_zero',
    name: 'Is Less Than Zero',
    group: 'Flow',
    description: 'Compare if a context value is less than zero.',
    configuration: [self::OPERATOR => Criterion::LT, self::TEST_VALUE => 0])]
#[CatalogNodeDecorator(
    key:'is_less_than_equal_zero',
    name: 'Is Less Than or Equal to Zero',
    group: 'Flow',
    description: 'Compare if a context value is less than or equal to zero.',
    configuration: [self::OPERATOR => Criterion::LTE, self::TEST_VALUE => 0])]
class ContextValueComparatorNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        EmptyConfigurationDescriptionTrait,
        ContextValueTrait,
        BooleanResultsTrait;

    const KEY = 'context_value_comparator';

    const NAME = 'Data Value Comparator';

    const DESCRIPTION = 'Test a value in the context against a value in the configuration with an operator';

    public const TEST_VALUE = 'test_value';

    public const OPERATOR = 'operator';

    public const CONTEXT_PATH = 'context_path';

    public function __construct(
        /**
         * The object that can use a path to read a value from a complex
         * object or array.
         */
        DataPathReaderInterface $dataPathReader = new DataPathReader(),
        /**
         * The object that can compare two different values.
         */
        protected ComparatorInterface $comparator = new Comparator()
    ) {
        $this->setMeta(
            self::KEY,
            self::NAME,
            self::DESCRIPTION,
            NodeCodeCategoryInterface::FLOW
        )->setConfigurationManager(new ConfigurationManager())
            ->setDataPathReader($dataPathReader);
    }

    /**
     * @inheritDoc
     * @throws     UnknownTypeException
     * @throws     MissingConfigurationValueException|UnknownComparatorException
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $contextPath = $this->getRequiredStringConfigurationValue(self::CONTEXT_PATH);
        $testValue = $this->getRequiredConfigurationValue(self::TEST_VALUE);
        $operator = $this->getRequiredConfigurationValue(self::OPERATOR);
        $contextValue = $this->getValueFromContext($contextPath, $context);
        if ($this->comparator->compare($contextValue, $operator, $testValue)) {
            if (is_array($testValue)) {
                $testValue = implode(',', $testValue);
            }
            return $this->result(
                ResultInterface::TRUE,
                'The "%s" context value passes the "%s" test with test value "%s".',
                [$contextValue, $operator, $testValue]
            );
        } else {
            if (is_array($contextValue)) {
                $contextValue = implode(',', $contextValue);
            }
            if (is_array($testValue)) {
                $testValue = implode(',', $testValue);
            }
            return $this->result(
                ResultInterface::FALSE,
                'The "%s" context value does not pass the "%s" test with test value "%s".',
                [$contextValue, $operator, $testValue]
            );
        }
    }
}
