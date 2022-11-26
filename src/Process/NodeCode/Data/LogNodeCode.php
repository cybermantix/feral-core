<?php

namespace NoLoCo\Core\Process\NodeCode\Data;

use Exception;
use NoLoCo\Core\Process\Configuration\ConfigurationManager;
use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Exception\MissingConfigurationValueException;
use NoLoCo\Core\Process\NodeCode\Category\NodeCodeCategoryInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\ConfigurationDescriptionInterface;
use NoLoCo\Core\Process\NodeCode\Configuration\Description\StringArrayConfigurationDescription;
use NoLoCo\Core\Process\NodeCode\NodeCodeInterface;
use NoLoCo\Core\Process\NodeCode\Traits\ConfigurationTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ConfigurationValueTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ContextValueTrait;
use NoLoCo\Core\Process\NodeCode\Traits\EmptyConfigurationDescriptionTrait;
use NoLoCo\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use NoLoCo\Core\Process\NodeCode\Traits\ResultsTrait;
use NoLoCo\Core\Process\Result\ResultInterface;
use NoLoCo\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Sent a message to the logs. The message can include
 * token variables which will be replaced with values
 * from the context.
 *
 * Configuration Keys
 *  message  - The message to log
 *  level - the log level to use
 *
 * @package NoLoCo\Core\Process\Node\Data
 */
class LogNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait;
    use ResultsTrait;
    use ConfigurationTrait;
    use ConfigurationValueTrait;
    use EmptyConfigurationDescriptionTrait;
    use ContextValueTrait;

    const KEY = 'log';

    const NAME = 'Log Message';

    const DESCRIPTION = 'Log a message into the system logger.';

    public const MESSAGE = 'message';
    public const LEVEL = 'level';

    public function __construct(
        protected LoggerInterface $logger,
        ConfigurationManager $configurationManager = new ConfigurationManager()
    ) {
        $this->setMeta(
            self::KEY,
            self::NAME,
            self::DESCRIPTION,
            NodeCodeCategoryInterface::DATA
        )
            ->setConfigurationManager($configurationManager);
    }


    /**
     * @return ConfigurationDescriptionInterface[]
     */
    public function getConfigurationDescriptions(): array
    {
        return [
            (new StringArrayConfigurationDescription())
                ->setKey(self::MESSAGE)
                ->setName('Message')
                ->setDescription('The message to log.'),
            (new StringArrayConfigurationDescription())
                ->setKey(self::LEVEL)
                ->setName('Level')
                ->setDescription('The logger level')
                ->setOptions(
                    [
                    LogLevel::DEBUG,
                    LogLevel::INFO,
                    LogLevel::WARNING,
                    LogLevel::ERROR,
                    LogLevel::CRITICAL,
                    ]
                ),
        ];
    }

    /**
     * @inheritDoc
     * @throws     MissingConfigurationValueException|UnknownComparatorException
     * @throws     Exception
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $message = $this->getRequiredConfigurationValue(self::MESSAGE);
        $level = $this->getRequiredConfigurationValue(self::LEVEL, LogLevel::INFO);

        foreach ($context->getAll() as $key => $value) {
            if (is_object($value)) {
                $value = 'object';
            }
            $message = str_replace('{' . $key . '}', $value, $message);
        }
        $this->logger->log($level, $message);

        return $this->result(
            ResultInterface::OK,
            'Logged the message to the logger.',
            []
        );
    }
}
