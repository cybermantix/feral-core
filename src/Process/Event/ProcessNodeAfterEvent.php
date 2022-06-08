<?php

namespace NoLoCo\Core\Process\Event;

use NoLoCo\Core\Process\Context\ContextInterface;
use NoLoCo\Core\Process\Node\NodeInterface;
use NoLoCo\Core\Process\Result\ResultInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * An event from a process after the node has been processed
 * and has a result.
 * @package NoLoCo\Core\Process\Event
 */
class ProcessNodeAfterEvent extends Event
{

    /**
     * The node to be processed
     * @var array
     */
    protected NodeInterface $node;

    /**
     * @var ContextInterface
     */
    protected ContextInterface $context;

    /**
     * The result of the node being processed
     * @var ResultInterface
     */
    protected ResultInterface $result;

    /**
     * @return array
     */
    public function getNode(): NodeInterface|array
    {
        return $this->node;
    }

    /**
     * @param array $node
     * @return ProcessNodeAfterEvent
     */
    public function setNode(NodeInterface|array $node): ProcessNodeAfterEvent
    {
        $this->node = $node;
        return $this;
    }

    /**
     * @return ContextInterface
     */
    public function getContext(): ContextInterface
    {
        return $this->context;
    }

    /**
     * @param ContextInterface $context
     * @return ProcessNodeAfterEvent
     */
    public function setContext(ContextInterface $context): ProcessNodeAfterEvent
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @return ResultInterface
     */
    public function getResult(): ResultInterface
    {
        return $this->result;
    }

    /**
     * @param ResultInterface $result
     * @return ProcessNodeAfterEvent
     */
    public function setResult(ResultInterface $result): ProcessNodeAfterEvent
    {
        $this->result = $result;
        return $this;
    }
}
