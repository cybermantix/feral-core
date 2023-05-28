<?php

namespace Feral\Core\Process\Modification;
use Feral\Core\Process\ProcessInterface;

/**
 * Modify a process using a modification JSON
 */
interface ProcessModificationInterface
{
    public function modify (ProcessInterface $process, array $modificationJson): ProcessInterface;
}