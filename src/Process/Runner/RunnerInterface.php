<?php

namespace Feral\Core\Process\Runner;

use Feral\Core\Process\Context\ContextInterface;

/**
 * The top level object to run a process with a default set
 * of context data.
 */
interface RunnerInterface
{
    /**
     * The workflow run take a process key and get the process from
     * the process factory and process it with the process engine. A simple
     * key value parameter will init the context with the values passed in.
     * @param string $processKey
     * @param array $contextKeyValues
     * @param array $modifications
     * @return mixed
     */
    public function run(string $processKey, array $contextKeyValues = [], array $modifications = []) : ContextInterface;
}