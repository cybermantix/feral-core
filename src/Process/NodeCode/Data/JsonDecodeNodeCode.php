<?php

namespace Feral\Core\Process\NodeCode\Data;

use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Exception\MissingConfigurationValueException;
use Feral\Core\Process\Exception\ProcessException;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use Feral\Core\Process\NodeCode\Configuration\Description\StringConfigurationDescription;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Feral\Core\Process\NodeCode\Traits\ConfigurationValueTrait;
use Feral\Core\Process\NodeCode\Traits\ContextMutationTrait;
use Feral\Core\Process\NodeCode\Traits\ContextValueTrait;
use Feral\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\OkResultsTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Filter\Criterion;
use Feral\Core\Utility\Search\DataPathReader;
use Feral\Core\Utility\Search\DataPathReaderInterface;
use Feral\Core\Utility\Search\DataPathWriter;
use Feral\Core\Utility\Search\Exception\UnknownTypeException;
use Feral\Core\Process\Attributes\CatalogNodeDecorator;

/**
 * Decode a JSON string into an array.
 */
#[CatalogNodeDecorator(
    key:'json_decode',
    name: 'JSON Decode',
    group: 'Data',
    description: 'Convert a string from json into an associative array.',
    configuration: [
        self::CONTEXT_PATH => self::DEFAULT_CONTEXT_PATH,
        self::GET_CONTEXT_PATH => self::DEFAULT_GET_CONTEXT_PATH
    ]
)]
class JsonDecodeNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        EmptyConfigurationDescriptionTrait,
        ContextValueTrait,
        ContextMutationTrait,
        OkResultsTrait;

    const KEY = 'json_decode';

    const NAME = 'JSON Decode';

    const DESCRIPTION = 'Convert JSON data to an array in the context';

    public const DEFAULT_GET_CONTEXT_PATH = '_results';
    public const DEFAULT_CONTEXT_PATH = '_data';
    public const CONTEXT_PATH = 'context_path';
    public const GET_CONTEXT_PATH = 'get_context_path';

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
            (new StringConfigurationDescription())
                ->setKey(self::CONTEXT_PATH)
                ->setName('Context Path')
                ->setDescription('The context path where the returned data is held.')
            (new StringConfigurationDescription())
                ->setKey(self::GET_CONTEXT_PATH)
                ->setName('Get Context Path')
                ->setDescription('The context path to read the JSON string from.')

        ];
    }

    /**
     * @inheritDoc
     * @throws MissingConfigurationValueException
     * @throws UnknownTypeException
     * @throws ProcessException
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $contextPath = $this->getRequiredConfigurationValue(self::CONTEXT_PATH, self::DEFAULT_CONTEXT_PATH);
        $getContextPath = $this->getRequiredConfigurationValue(self::GET_CONTEXT_PATH, self::DEFAULT_GET_CONTEXT_PATH);

        $jsonString = $this->getStringValueFromContext($getContextPath, $context);
        $arrayData = json_decode($jsonString, true);
        $this->setValueInContext(self::CONTEXT_PATH, $arrayData, $context);

        return $this->result(
            ResultInterface::OK,
            'Converted string data from path "%s" and placed in path "%s"',
            [$getContextPath, $contextPath]
        );
    }
}