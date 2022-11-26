<?php

namespace NoLoCo\Core\Process\Validator;

use NoLoCo\Core\Process\ProcessInterface;

/**
 * Run the nodes, edges, and start key against all the available
 * validators.
 */
interface ProcessValidatorInterface
{
    /**
     * Validate the nodes, edges, and start key used in a process engine.
     * @param ProcessInterface $process
     * @param string $startKey
     * @return string[]
     */
    public function validate(ProcessInterface $process, string $startKey = 'start'): array;

}