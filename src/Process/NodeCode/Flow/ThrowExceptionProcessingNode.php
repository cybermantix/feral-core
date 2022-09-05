<?php


namespace NoLoCo\Core\Process\NodeCode\FlowControl;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\AbstractNodeCode;
use NoLoCo\Core\Process\NodeCode\Exception\ProcessException;
use NoLoCo\Core\Process\Result\ResultInterface;

/**
 * If an error is received then convert the error into an exception.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
 * @package NoLoCo\Core\Process\Node\FlowControl
 */
class ThrowExceptionProcessingNode extends AbstractNodeCode
{
    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        throw new ProcessException('An error occurred during a process. Please review the process logs.');
    }
}
