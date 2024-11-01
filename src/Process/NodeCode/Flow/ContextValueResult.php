<?php

namespace Feral\Core\Process\NodeCode\Flow;

use Feral\Core\Process\Attributes\CatalogNodeDecorator;
use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Attributes\ContextConfigurationDescription;
use Feral\Core\Process\Attributes\OkResultDescription;
use Feral\Core\Process\Attributes\ResultDescription;
use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Exception\MissingConfigurationValueException;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Feral\Core\Process\NodeCode\Traits\ConfigurationValueTrait;
use Feral\Core\Process\NodeCode\Traits\ContextValueTrait;
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

#[StringConfigurationDescription(
    key: self::CONTEXT_PATH,
    name: 'Context Path',
    description: 'The context path to return in the result'
)]/**
 * Class ComparatorNode
 * Start the process by returning the OK status.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
 */
#[CatalogNodeDecorator(
    key:'context_value_result',
    name: 'Content Value Result',
    group: 'Flow',
    description: 'Return a contect value as a result')]
#[ResultDescription(result: "*", description: 'Output the result from the value of a context node.')]
class ContextValueResult implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        ContextValueTrait;

    const KEY = 'context-value-result';
    const NAME = 'Content Value Result';
    const DESCRIPTION = 'The result is the value of a context value.';
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
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $contextPath = $this->getRequiredStringConfigurationValue(self::CONTEXT_PATH);
        $contextValue = $this->getValueFromContext($contextPath, $context);
        if (!is_string($contextValue)) {
            throw new \Exception('Only a string can be returned in the result.');
        }
        return $this->result($contextValue, 'Returning value from "%s"', [$contextPath]);
    }
}
