<?php


namespace NoLoCo\Core\Process\NodeCode\FlowControl;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\NodeCode\AbstractNodeCode;
use NoLoCo\Core\Process\Result\ResultInterface;
use NoLoCo\Core\Utility\Search\DataPathReaderInterface;

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
    const KEY = 'start';

    const NAME = 'Start Process';

    const DESCRIPTION = 'The node that starts a process.';

    public function __construct(DataPathReaderInterface $dataPathReader, array $configuration)
    {
        parent::__construct($dataPathReader, $configuration);
        $this->setMeta(self::KEY, self::NAME, self::DESCRIPTION);
    }


    /**
     * @inheritDoc
     */
    public function process(ContextInterface $context): ResultInterface
    {
        return $this->result(ResultInterface::OK, 'Start processing.');
    }
}
