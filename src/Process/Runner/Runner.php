<?php

namespace Feral\Core\Process\Runner;

use Exception;
use Feral\Core\Process\Context\Context;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Engine\ProcessEngine;
use Feral\Core\Process\Exception\InvalidNodeKey;
use Feral\Core\Process\Modification\JSONModificationInterface;
use Feral\Core\Process\ProcessFactory;

/**
 * Take a process and run it with an initial context. Allow
 * optional modifications to the process.
 */
class Runner implements RunnerInterface
{

    public function __construct(
        private ProcessFactory $factory,
        private ProcessEngine $engine,
        private JSONModificationInterface $modification
    ){}

    /**
     * @inheritDoc
     * @throws InvalidNodeKey
     * @throws Exception
     */
    public function run(string $processKey, array $contextKeyValues = [], array $modifications = []): ContextInterface
    {
        $context = new Context();
        foreach ($contextKeyValues as $key => $value) {
            $context->set($key, $value);
        }

        $process = $this->factory->build($processKey);
        $this->engine->process($process, $context);
        return $context;
    }
}