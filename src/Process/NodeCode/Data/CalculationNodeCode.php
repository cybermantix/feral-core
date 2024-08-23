<?php

namespace Feral\Core\Process\NodeCode\Data;

use Exception;
use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
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
use Feral\Core\Process\NodeCode\Traits\ContextMutationTrait;
use Feral\Core\Process\NodeCode\Traits\ContextValueTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use Feral\Core\Utility\Search\DataPathReader;
use Feral\Core\Utility\Search\DataPathReaderInterface;
use Feral\Core\Utility\Search\DataPathWriter;

/**
 * A simple math node that can run arithmetic operations on data stored
 * in different context values.
 *
 * Configuration Keys
 *  context_path - The path in the context
 *  x_context_path - The path in the context to the left constant
 *  y_context_path - The path in the context to the right constant
 *  result_context_path - The path in the context to store the result
 *  operation - The path in the context to store the result
 *
 * Results
 *  ok - The arithmetic operation has been run and the results added to the context
 */

#[StringConfigurationDescription(
    key: self::X_CONTEXT_PATH,
    name: 'X Context Path',
    description: 'The context path to the first variable, the left side, of the equation.'
)]
#[StringConfigurationDescription(
    key: self::Y_CONTEXT_PATH,
    name: 'Y Context Path',
    description: 'The context path to the second variable, the right side, of the equation.'
)]
#[StringConfigurationDescription(
    key: self::RESULT_PATH,
    name: 'Result Context Path',
    description: 'The context path to set the results of the operation.'
)]
#[StringConfigurationDescription(
    key: self::OPERATION,
    name: 'Calculation Operation',
    description: 'The mathematical operation to apply to the variables.',
    options: [
        self::ADD,
        self::SUBTRACT,
        self::MULTIPLY,
        self::DIVIDE,
        self::POWER,
    ]
)]
#[OkResultDescription(description: 'The calculation was successful.')]
class CalculationNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        ContextValueTrait,
        ContextMutationTrait;

    const KEY = 'calculation';
    const NAME = 'Calculation';
    const X_CONTEXT_PATH = 'x_context_path';
    const Y_CONTEXT_PATH = 'y_context_path';
    const RESULT_PATH = 'result_context_path';
    const OPERATION = 'operation';
    const ADD = 'add';
    const SUBTRACT = 'subtract';
    const MULTIPLY = 'multiply';
    const DIVIDE = 'divide';
    const POWER = 'power';

    const DESCRIPTION = 'Take the values from two context paths and perform an operation and store the results in a context path.';


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
     * @inheritDoc
     * @throws     MissingConfigurationValueException|UnknownComparatorException
     * @throws     Exception
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $xPath = $this->getRequiredConfigurationValue(self::X_CONTEXT_PATH);
        $yPath = $this->getRequiredConfigurationValue(self::Y_CONTEXT_PATH);
        $operation = $this->getRequiredConfigurationValue(self::OPERATION);
        $resultPath = $this->getRequiredConfigurationValue(self::RESULT_PATH);
        $x = $this->getValueFromContext($xPath, $context);
        $y = $this->getValueFromContext($yPath, $context);
        $result = match($operation) {
            self::ADD => $x + $y,
            self::SUBTRACT => $x - $y,
            self::MULTIPLY => $x * $y,
            self::DIVIDE => $x / $y,
            self::POWER => pow($x, $y)
        };

        $this->setValueInContext($resultPath, $result, $context);

        return $this->result(
            ResultInterface::OK,
            'Applied operator "%s" path "%s" and "%s".',
            [$operation, $xPath, $yPath]
        );
    }
}
