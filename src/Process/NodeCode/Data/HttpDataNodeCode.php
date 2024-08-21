<?php

namespace Feral\Core\Process\NodeCode\Data;

use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Exception\MissingConfigurationValueException;
use Feral\Core\Process\Exception\ProcessException;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use Feral\Core\Process\NodeCode\Configuration\Description\IntConfigurationDescription;
use Feral\Core\Process\NodeCode\Configuration\Description\StringArrayConfigurationDescription;
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
use Feral\Core\Process\Result\Description\ResultDescriptionInterface;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Search\DataPathReader;
use Feral\Core\Utility\Search\DataPathReaderInterface;
use Feral\Core\Utility\Search\DataPathWriter;
use Feral\Core\Utility\Search\Exception\UnknownTypeException;

/**
 * Get data from a URL and store the results in a context.
 *
 * Configuration Keys
 *  context_path - The path in the context to store the results
 *  url - The URL to call to get the data
 *
 * Results
 *  ok - Data was read from the URL and stored in the context
 */
class HttpDataNodeCode implements \Feral\Core\Process\NodeCode\NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        EmptyConfigurationDescriptionTrait,
        ContextValueTrait,
        ContextMutationTrait,
        OkResultsTrait;

    const KEY = 'http_data';

    const NAME = 'HTTP Data';

    const DESCRIPTION = 'Make a call to an HTTP service to get data and store it in the context. Methods allowed are GET, POST, PUT, PATCH, and DELETE';

    public const DEFAULT_CONTEXT_PATH = '_results';
    public const CONTEXT_PATH = 'context_path';
    public const DATA_CONTEXT_PATH = 'data_context_path';
    public const CONFIG_DATA = 'config_data';
    public const URL = 'url';
    public const METHOD = 'method';
    public const DEFAULT_METHOD = 'GET';

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
                ->setKey(self::URL)
                ->setName('URL')
                ->setDescription('The URL to call to get the data.')
            (new StringConfigurationDescription())
                ->setKey(self::METHOD)
                ->setName('Method')
                ->setDescription('The HTTP Method to use to make the call. DEFAULT GET')
                ->setOptions([
                    'GET',
                    'POST',
                    'PUT',
                    'PATCH',
                    'DELETE',
                ])
            (new StringArrayConfigurationDescription())
                ->setKey(self::CONFIG_DATA)
                ->setName('Data')
                ->setDescription('Data to be added to the HTTP request.')
            (new StringArrayConfigurationDescription())
                ->setKey(self::DATA_CONTEXT_PATH)
                ->setName('Data Context Path')
                ->setDescription('The location of the data to be sent to the HTTP service')
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
        $url = $this->getRequiredConfigurationValue(self::URL);
        $method = $this->getRequiredStringConfigurationValue(self::METHOD, self::DEFAULT_METHOD);
        $configData = $this->getArrayConfigurationValue(self::CONFIG_DATA, []);
        $contextDataPath = $this->getStringConfigurationValue(self::DATA_CONTEXT_PATH, 'ctx_data');
        $contextData = $this->getValueFromContext($contextDataPath, $context);
        if (empty($contextData)){
            $contextData = [];
        } else if (is_string($contextData)) {
            $contextData = [$contextData];
        }
        $data = array_merge($configData, $contextData);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        switch (strtoupper($method)) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'PATCH':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case 'GET':
            default:
                if (!empty($data)) {
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                    curl_setopt($ch, CURLOPT_URL, $url);
                }
                break;
        }

        $response = curl_exec($ch);
        $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($response === false) {
            throw new ProcessException(sprintf(
                'cURL error connecting to "%s". Error: %s',
                $url,
                curl_error($ch)
            ));
        }

        $this->setValueInContext($contextPath, $response, $context);
        curl_close($ch);
        return $this->result(
            ResultInterface::OK,
            'cURL call to "%s" which returned code "%u" with %u bytes.',
            [$url, $responseCode, strlen($response)]
        );
    }
}