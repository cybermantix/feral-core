<?php

namespace Feral\Core\Process\NodeCode\Flow;

use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Exception\MissingConfigurationValueException;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use Feral\Core\Process\NodeCode\Configuration\Description\StringConfigurationDescription;
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
 * To see the list of available operators see \Nodez\Core\Utility\Filter\Criterion
 *
 * Configuration Keys
 *  operator    - The operator used in the test
 *  test_value  - The value used to test the actual value in the context
 *  context_path - The key used to retrieve the actual value from the context
 *
 * @package Nodez\Core\Process\Node\FlowControl
 */
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
     * @return ConfigurationDescriptionInterface[]
     */
    public function getConfigurationDescriptions(): array
    {
        return [
            (new StringConfigurationDescription())
                ->setKey(self::OPERATOR)
                ->setName('Comparison Operator')
                ->setDescription('The operator to compare the context value in the path to the value stored')
                ->setOptions(
                    [
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
                ),
            (new StringConfigurationDescription())
                ->setKey(self::TEST_VALUE)
                ->setName('Test Value')
                ->setDescription('The value to compare the context value to.'),
            (new StringConfigurationDescription())
                ->setKey(self::CONTEXT_PATH)
                ->setName('Data Path')
                ->setDescription('The context path to get the value being tested.'),
        ];
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
