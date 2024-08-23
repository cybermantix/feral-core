<?php

namespace Feral\Core\Process\NodeCode\Data;

use Exception;
use Feral\Core\Process\Attributes\ConfigurationDescriptionInterface;
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
use Feral\Core\Process\NodeCode\Traits\ContextValueTrait;
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Filter\Comparator\Exception\UnknownComparatorException;
use Feral\Core\Utility\Template\Template;
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
 */
#[StringConfigurationDescription(
    key: self::MESSAGE,
    name: 'Message',
    description: 'The message to log.'
)]
#[StringConfigurationDescription(
    key: self::LEVEL,
    name: 'Level',
    description: 'The logger level',
    options: [
        LogLevel::DEBUG,
        LogLevel::NOTICE,
        LogLevel::INFO,
        LogLevel::WARNING,
        LogLevel::ERROR,
        LogLevel::CRITICAL,
    ]
)]
#[OkResultDescription(description: 'The message logging was successful.')]
class LogNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait,
        ContextValueTrait;

    const KEY = 'log';

    const NAME = 'Log Message';

    const DESCRIPTION = 'Log a message into the system logger.';

    public const MESSAGE = 'message';
    public const LEVEL = 'level';

    public function __construct(
        protected LoggerInterface $logger,
        protected Template $template = new Template(),
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
     * @inheritDoc
     * @throws     MissingConfigurationValueException|UnknownComparatorException
     * @throws     Exception
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $message = $this->getRequiredConfigurationValue(self::MESSAGE);
        $level = $this->getRequiredConfigurationValue(self::LEVEL, LogLevel::INFO);

        $message = $this->template->replace($message, $context->getAll());
        $this->logger->log($level, $message);

        return $this->result(
            ResultInterface::OK,
            'Logged the message to the logger.',
            []
        );
    }
}
