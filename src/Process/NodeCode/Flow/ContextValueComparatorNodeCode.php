<?php


namespace NoLoCo\Core\Process\NodeCode\FlowControl;

use NoLoCo\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\StringArrayConfigurationDescription;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\StringConfigurationDescription;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Utility\Filter\Comparator\Comparator;
use NoLoCo\Core\Utility\Filter\Comparator\ComparatorInterface;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\AbstractNodeCode;
use NoLoCo\Core\Process\Result\ResultInterface;
use NoLoCo\Core\Utility\Filter\Criterion;
use NoLoCo\Core\Utility\Search\DataPathReader;
use NoLoCo\Core\Utility\Search\DataPathReaderInterface;

/**
 * Class ComparatorNode
 * Test if a value in the context passes a test with an operator.
 * To see the list of available operators see \NoLoCo\Core\Utility\Filter\Criterion
 *
 * Configuration Keys
 *  operator    - The operator used in the test
 *  test_value  - The value used to test the actual value in the context
 *  key         - The key used to retrieve the actual value from the context
 *
 * @package NoLoCo\Core\Process\Node\FlowControl
 */
class ContextValueComparatorNodeCode implements NodeCodeInterface {


    const KEY = 'context_value_comparator';

    const NAME = 'Context Value Comparator';

    const DESCRIPTION = 'Test a value in the context against a value in the configuration with an operator';

    protected const TEST_VALUE = 'test_value';

    protected const OPERATOR = 'operator';

    protected const CONTEXT_PATH = 'context_path';

    protected ComparatorInterface $comparator;

    /**
     * ValueComparatorNode constructor.
     * @param DataPathReaderInterface $dataPathReader
     * @param ComparatorInterface|null $comparator
     */
    public function __construct(
        public DataPathReaderInterface $dataPathReader,
        ComparatorInterface $comparator = null
    ) {
        if ($comparator) {
            $this->comparator = $comparator;
        } else {
            $this->comparator = new Comparator();
        }
    }

    /**
     * @see NodeCodeInterface::getKey()
     */
    public function getKey(): string
    {
        return self::KEY;
    }

    /**
     * @see NodeCodeInterface::getName()
     */
    public function getName(): string
    {
        return self::NAME;
    }

    /**
     * @see NodeCodeInterface::getDescription()
     */
    public function getDescription(): string
    {
        return self::DESCRIPTION;
    }

    /**
     * @see NodeCodeInterface::getCategoryKey()
     */
    public function getCategoryKey(): string
    {
        return NodeCodeCategoryInterface::FLOW;
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
                ->setOptions([
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
                ]),
            (new StringConfigurationDescription())
                ->setKey(self::TEST_VALUE)
                ->setName('Test Value')
                ->setDescription('The value to compare the context value to.'),
            (new StringConfigurationDescription())
                ->setKey(self::CONTEXT_PATH)
                ->setName('Context Path')
                ->setDescription('The context path to get the value being tested.'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $testValue = $this->getConfigurationValue(self::TEST_VALUE);
        $operator = $this->getStringConfigurationValue(self::OPERATOR);
        $contextValue = $this->getValueFromContext($this->getStringConfigurationValue(self::CONTEXT_PATH), $context);

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
