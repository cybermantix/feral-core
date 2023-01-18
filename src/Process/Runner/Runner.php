<?php

namespace Feral\Core\Process\Runner;

use Exception;
use Feral\Core\Process\Context\Context;
use Feral\Core\Process\Context\ContextInterface;
use Feral\Core\Process\Engine\ProcessEngine;
use Feral\Core\Process\Exception\InvalidNodeKey;
use Feral\Core\Process\ProcessFactory;

class Runner implements RunnerInterface
{

    public function __construct(
        private ProcessFactory $factory,
        private ProcessEngine $engine
    ){}

    /**
     * @inheritDoc
     * @throws InvalidNodeKey
     * @throws Exception
     */
    public function run(string $processKey, array $contextKeyValues = []): ContextInterface
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