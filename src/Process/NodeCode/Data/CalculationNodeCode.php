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
use Nodez\Core\Utility\Search\DataPathReader;
use Nodez\Core\Utility\Search\DataPathReaderInterface;
use Nodez\Core\Utility\Search\DataPathWriter;

/**
 * Create a counter that ticks every pass through the
 * node.
 *
 * Configuration Keys
 *  context_path - The path in the context
 *
 * @package Nodez\Core\Process\Node\Data
 */
class CalculationNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        EmptyConfigurationDescriptionTrait,
        ContextValueTrait,
        ContextMutationTrait,
        OkResultsTrait;

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
     * @return ConfigurationDescriptionInterface[]
     */
    public function getConfigurationDescriptions(): array
    {
        return [
            (new StringArrayConfigurationDescription())
                ->setKey(self::X_CONTEXT_PATH)
                ->setName('X Context Path')
                ->setDescription('The context path to the first variable, the left side, of the equation.'),
            (new StringArrayConfigurationDescription())
                ->setKey(self::Y_CONTEXT_PATH)
                ->setName('Y Context Path')
                ->setDescription('The context path to the second variable, the right side, of the equation.'),
            (new StringArrayConfigurationDescription())
                ->setKey(self::RESULT_PATH)
                ->setName('Result Context Path')
                ->setDescription('The context path to set the results of the operation.'),
            (new StringConfigurationDescription())
                ->setKey(self::OPERATION)
                ->setName('Calculation Operation')
                ->setDescription('The mathematical operation to apply to the variables.')
                ->setOptions(
                    [
                        self::ADD,
                        self::SUBTRACT,
                        self::MULTIPLY,
                        self::DIVIDE,
                        self::POWER,
                    ]
                )
        ];
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
