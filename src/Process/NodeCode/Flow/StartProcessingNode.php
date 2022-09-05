<?php


namespace NoLoCo\Core\Process\NodeCode\FlowControl;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\AbstractNodeCode;
use NoLoCo\Core\Process\Result\ResultInterface;

/**
 * Class ComparatorNode
 * Start the process by returning the OK status.
 *
 * Configuration Keys
 *  (No Configuration keys)
 *
 * @package NoLoCo\Core\Process\Node\FlowControl
 */
class StartProcessingNode extends AbstractNodeCode
{
    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        return $this->result(ResultInterface::OK, 'Start processing.');
    }
}
