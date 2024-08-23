<?php

namespace Feral\Core\Process\NodeCode\Data;

use Exception;
use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
use Feral\Core\Process\Attributes\ContextConfigurationDescription;
use Feral\Core\Process\Attributes\OkResultDescription;
use Feral\Core\Process\Attributes\StringArrayConfigurationDescription;
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
use Feral\Core\Utility\Search\DataPathReaderInterface;
use Feral\Core\Utility\Search\DataPathWriter;

/**
 * Set the value of a context key to a configured value. To set a deep reference
 * the parent object|array must exist.
 *
 * Configuration Keys
 *  table  - The associative array
 *
 */
#[ContextConfigurationDescription]
#[StringConfigurationDescription(
    key: self::TABLE,
    name: 'Table',
    description: 'Set multiple values in the context.'
)]
#[OkResultDescription(description: 'The array of data was set successfully.')]
class SetContextTableNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        ContextValueTrait,
        ContextMutationTrait;

    const KEY = 'set_context_table';

    const NAME = 'Set Context Table';

    const DESCRIPTION = '`Set multiple values in the context using a table (associative array)`';

    public const TABLE = 'table';

    public const CONTEXT_PATH = 'context_path';

    public function __construct(
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
            ->setDataPathWriter($dataPathWriter);
    }

    /**
     * @inheritDoc
     * @throws     MissingConfigurationValueException
     * @throws     Exception
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $table = $this->getRequiredArrayConfigurationValue(self::TABLE);
        $contextPath = $this->getRequiredConfigurationValue(self::CONTEXT_PATH, '');
        if (!empty($contextPath)) {
            $contextPath .= DataPathReaderInterface::DEFAULT_DELIMITER;
        }
        foreach ($table as $key => $value) {
            $path = $contextPath . $key;
            $this->setValueInContext($path, $value, $context);
        }

        return $this->result(
            ResultInterface::OK,
            'Table of values set in the context.',
            []
        );
    }
}
