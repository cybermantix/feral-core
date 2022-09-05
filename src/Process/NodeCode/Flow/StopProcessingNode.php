<?php


namespace NoLoCo\Core\Process\NodeCode\FlowControl;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\AbstractNodeCode;
use NoLoCo\Core\Process\Result\ResultInterface;

/**
 * Class ComparatorNode
 * Stop the process by returning the stop status.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
 * @package NoLoCo\Core\Process\Node\FlowControl
 */
class StopProcessingNode extends AbstractNodeCode
{
    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        return $this->result(ResultInterface::STOP, 'Stop processing.');
    }
}
