<?php

namespace Feral\Core\Process\NodeCode\Data;

use Feral\Core\Process\Attributes\CatalogNodeDecorator;
use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Attributes\ContextConfigurationDescription;
use Feral\Core\Process\Attributes\OkResultDescription;
use Feral\Core\Process\Attributes\StringArrayConfigurationDescription;
use Feral\Core\Process\Attributes\StringConfigurationDescription;
use Feral\Core\Process\Configuration\ConfigurationManager;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Exception\MissingConfigurationValueException;
use Feral\Core\Process\Exception\ProcessException;
use Feral\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use Feral\Core\Process\NodeCode\NodeCodeInterface;
use Feral\Core\Process\NodeCode\Traits\ConfigurationTrait;
use Feral\Core\Process\NodeCode\Traits\ConfigurationValueTrait;
use Feral\Core\Process\NodeCode\Traits\ContextMutationTrait;
use Feral\Core\Process\NodeCode\Traits\ContextValueTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
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
#[ContextConfigurationDescription]
#[StringConfigurationDescription(
    key: self::URL,
    name: 'URL',
    description: 'The URL to call to get the data.'
)]
#[StringConfigurationDescription(
    key: self::METHOD,
    name: 'Method',
    description: 'The HTTP Method to use to make the call. DEFAULT GET',
    default: self::DEFAULT_METHOD,
    options: [
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
    ]
)]
#[StringConfigurationDescription(
    key: self::CONFIG_DATA,
    name: 'Data',
    description: 'Data to be added to the HTTP request.',
    isOptional: true
)]
#[StringConfigurationDescription(
    key: self::DATA_CONTEXT_PATH,
    name: 'Data Context Path',
    description: 'The location of the data to be sent to the HTTP service.',
    isOptional: true
)]
#[StringConfigurationDescription(
    key: self::BEARER_TOKEN,
    name: 'Bearer Token',
    description: 'The bearer token to send with the call',
    isSecret: true,
    isOptional: true
)]
#[CatalogNodeDecorator(
    key:'http_get',
    name: 'HTTP Get',
    group: 'Data',
    description: 'Send a GET call to an endpoint.',
    configuration: [
        self::METHOD => self::METHOD_POST
    ]
)]
#[CatalogNodeDecorator(
    key:'http_post',
    name: 'HTTP Post',
    group: 'Data',
    description: 'Send a POST call to an endpoint.',
    configuration: [
        self::METHOD => self::METHOD_POST
    ]
)]
#[CatalogNodeDecorator(
    key:'http_put',
    name: 'HTTP Put',
    group: 'Data',
    description: 'Send a PUT call to an endpoint.',
    configuration: [
        self::METHOD => self::METHOD_PUT
    ]
)]
#[CatalogNodeDecorator(
    key:'http_patch',
    name: 'HTTP Patch',
    group: 'Data',
    description: 'Send a PATCH call to an endpoint.',
    configuration: [
        self::METHOD => self::METHOD_PATCH
    ]
)]
#[CatalogNodeDecorator(
    key:'http_delete',
    name: 'HTTP Delete',
    group: 'Data',
    description: 'Send a DELETE call to an endpoint.',
    configuration: [
        self::METHOD => self::METHOD_DELETE
    ]
)]
#[OkResultDescription(description: 'The HTTP request was successful.')]
class HttpDataNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        ContextValueTrait,
        ContextMutationTrait;

    const KEY = 'http_data';

    const NAME = 'HTTP Data';

    const DESCRIPTION = 'Make a call to an HTTP service to get data and store it in the context. Methods allowed are GET, POST, PUT, PATCH, and DELETE';

    public const DEFAULT_CONTEXT_PATH = '_results';
    public const OUTPUT_CONTEXT_PATH = 'output_context_path';
    public const BEARER_TOKEN = 'bearer_token';
    public const DATA_CONTEXT_PATH = 'data_context_path';
    public const CONFIG_DATA = 'config_data';
    public const URL = 'url';
    public const METHOD = 'method';
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';
    public const METHOD_PUT = 'PUT';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';
    public const DEFAULT_METHOD = self::METHOD_GET;

    public const RESULT_BODY = 'body';
    public const RESULT_CODE = 'code';
    public const RESULT_HEADERS = 'headers';

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
     * @throws MissingConfigurationValueException
     * @throws UnknownTypeException
     * @throws ProcessException
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $contextPath = $this->getRequiredConfigurationValue(self::OUTPUT_CONTEXT_PATH, self::DEFAULT_CONTEXT_PATH);
        $url = $this->getRequiredConfigurationValue(self::URL);
        $method = $this->getRequiredStringConfigurationValue(self::METHOD, self::DEFAULT_METHOD);
        $bearerToken = $this->getStringSecretConfigurationValue(self::BEARER_TOKEN);
        $data = $this->getArrayConfigurationValue(self::CONFIG_DATA, []);
        $contextDataPath = $this->getStringConfigurationValue(self::DATA_CONTEXT_PATH, 'ctx_data');
        $contextData = $this->getValueFromContext($contextDataPath, $context);
        if (!empty($contextData)){
            $data = $contextData;
        }
        $headers = [];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        switch (strtoupper($method)) {
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case 'PUT':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                break;
            case 'PATCH':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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

        if (!empty($bearerToken)) {
            $headers[] = 'Authorization: Bearer ' . $bearerToken;
        }

        // HEADERS
        $headers[] = 'Content-Type: application/json';
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
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

        // Separate the headers and the body
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $responseHeaders = $this->parseHeaders(substr($response, 0, $headerSize));
        $responseBody = substr($response, $headerSize);

        $results = [
            self::RESULT_BODY => $responseBody,
            self::RESULT_CODE => $responseCode,
            self::RESULT_HEADERS => $responseHeaders
        ];

        $this->setValueInContext($contextPath, $results, $context);
        curl_close($ch);
        return $this->result(
            ResultInterface::OK,
            'cURL "%s" call to "%s" which returned code "%u" with %u bytes.',
            [$method, $url, $responseCode, strlen($responseBody)]
        );
    }

    protected function parseHeaders(string $headers): array
    {
        $headerLines = explode("\r\n", trim($headers));
        $headerArray = [];

        foreach ($headerLines as $headerLine) {
            if (strpos($headerLine, ':') !== false) {
                list($key, $value) = explode(':', $headerLine, 2);
                $headerArray[trim($key)] = trim($value);
            } elseif (preg_match('#HTTP/[0-9\.]+\s+([0-9]+)#', $headerLine, $matches)) {
                $headerArray['status_code'] = $matches[1];
            }
        }

        return $headerArray;
    }
}