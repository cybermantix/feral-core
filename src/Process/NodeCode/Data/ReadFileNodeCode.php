<?php

namespace Feral\Core\Process\NodeCode\Data;

use Exception;
use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Attributes\ContextConfigurationDescription;
use Feral\Core\Process\Attributes\IntConfigurationDescription;
use Feral\Core\Process\Attributes\OkResultDescription;
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
use Feral\Core\Utility\Filesystem\FileWrapper;
use Feral\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use Feral\Core\Utility\Search\DataPathReader;
use Feral\Core\Utility\Search\DataPathReaderInterface;
use Feral\Core\Utility\Search\DataPathWriter;

/**
 * Read the contents of a file into the context
 *
 * Configuration Keys
 *  file - The path to the file
 *  context_path - The path in the context to set the random number
 *  maximum_file_size - The maximum file size to allow
 *
 */
#[ContextConfigurationDescription]
#[StringConfigurationDescription(
    key: self::FILE,
    name: 'File Path',
    description: 'The path to the file to read.'
)]
#[IntConfigurationDescription(
    key: self::MAXIMUM_SIZE,
    name: 'Maximum Size',
    description: 'The maximum file size allowed to be read. Defaults ot 1MB.'
)]
#[OkResultDescription(description: 'The file was read successfully.')]
class ReadFileNodeCode implements NodeCodeInterface
{
    const DEFAULT_MAXIMUM_SIZE = 1024 ** 2;

    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        ContextValueTrait,
        ContextMutationTrait;

    const KEY = 'read_file';
    const NAME = 'Read File';
    const FILE = 'file';
    const MAXIMUM_SIZE = 'maximum_size';
    const DESCRIPTION = 'Read the contents of a file into the context.';


    public function __construct(
        DataPathReaderInterface $dataPathReader = new DataPathReader(),
        DataPathWriter $dataPathWriter = new DataPathWriter(),
        ConfigurationManager $configurationManager = new ConfigurationManager(),
        private FileWrapper $fileWrapper = new FileWrapper()
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
        $filePath = $this->getRequiredConfigurationValue(self::FILE);
        $path = $this->getRequiredConfigurationValue(self::CONTEXT_PATH);
        $maximumSize = $this->getRequiredConfigurationValue(self::MAXIMUM_SIZE, self::DEFAULT_MAXIMUM_SIZE);

        if (!$this->fileWrapper->isFile($filePath)) {
            throw new \Exception(sprintf('File path "%s" does not exist.', $filePath));
        } elseif (!$this->fileWrapper->isReadable($filePath)) {
            throw new \Exception(sprintf('File path "%s" does not readable.', $filePath));
        } elseif ($maximumSize < $this->fileWrapper->getFilesize($filePath)) {
            throw new \Exception(sprintf('File "%s" is larger than the maximum filesize allowed "%u".', $filePath, $maximumSize));
        }

        $value = $this->fileWrapper->getFileContents($filePath);
        $this->setValueInContext($path, $value, $context);

        return $this->result(
            ResultInterface::OK,
            'Read "%u" characters from file "%s".',
            [strlen($value), $value]
        );
    }
}
