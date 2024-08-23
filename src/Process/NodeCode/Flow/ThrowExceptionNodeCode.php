<?php

namespace Feral\Core\Process\NodeCode\Flow;

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
use Feral\Core\Process\NodeCode\Traits\NodeCodeMetaTrait;
use Feral\Core\Process\NodeCode\Traits\ResultsTrait;
use Feral\Core\Process\Result\ResultInterface;
use Feral\Core\Utility\Template\Template;

/**
 * If an error is received then convert the error into an exception.
 *
 * Configuration Keys
 *  message - The message to throw
 */
#[StringConfigurationDescription(
    key: self::MESSAGE,
    name: 'Message',
    description: 'The message for the exception. Use context values with the key and mustache style includes.'
)]
class ThrowExceptionNodeCode implements NodeCodeInterface
{
    use NodeCodeMetaTrait,
        ResultsTrait,
        ConfigurationTrait,
        ConfigurationValueTrait;

    const KEY = 'throw_exception';
    const NAME = 'Throw Exception';
    const DESCRIPTION = 'Throw an exception in the process.';
    public const MESSAGE = 'message';

    public function __construct(protected Template $template = new Template(),)
    {
        $this->setMeta(
            self::KEY,
            self::NAME,
            self::DESCRIPTION,
            NodeCodeCategoryInterface::FLOW
        )->setConfigurationManager(new ConfigurationManager());
    }

    /**
     * @inheritDoc
     * @throws     ProcessException|MissingConfigurationValueException
     */
    public function process(ContextInterface $context): ResultInterface
    {
        $message = $this->getRequiredConfigurationValue(self::MESSAGE);
        $message = $this->template->replace($message, $context->getAll());
        throw new ProcessException($message);
    }
}
