<?php


namespace NoLoCo\Core\Process\NodeCode\FlowControl;

use NoLoCo\Core\Utility\Filter\Comparator\Comparator;
use NoLoCo\Core\Utility\Filter\Comparator\ComparatorInterface;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\AbstractNodeCode;
use NoLoCo\Core\Process\Result\ResultInterface;
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
class ContextValueComparatorNode extends AbstractNodeCode
{
    const TEST_VALUE = 'test_value';

    const OPERATOR = 'operator';

    protected ComparatorInterface $comparator;

    /**
     * ValueComparatorNode constructor.
     * @param DataPathReaderInterface $dataPathReader
     * @param array|null $configuration
     * @param ComparatorInterface|null $comparator
     */
    public function __construct(
        DataPathReaderInterface $dataPathReader,
        array $configuration = [],
        ComparatorInterface $comparator = null
    ) {
        if ($comparator) {
            $this->comparator = $comparator;
        } else {
            $this->comparator = new Comparator();
        }
        parent::__construct($dataPathReader, $configuration);
    }

    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $testValue = $this->getConfigurationValue(self::TEST_VALUE);
        $operator = $this->getStringConfigurationValue(self::OPERATOR);
        $contextValue = $this->getValueFromContext($this->getStringConfigurationValue(self::CONTEXT_KEY), $context);

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
