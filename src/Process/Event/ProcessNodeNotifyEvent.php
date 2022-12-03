<?php

namespace Nodez\Core\Process\Event;

use Nodez\Core\Process\Context\ContextInterface;
use Nodez\Core\Process\Event\Traits\StoppableEventTrait;
use Nodez\Core\Process\NodeCode\NodeCodeInterface;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * @deprecated Not sure the purpose of this event.
 */
class ProcessNodeNotifyEvent implements StoppableEventInterface
{
    use StoppableEventTrait;

    /**
     * The node dispatching the event.
     *
     * @var NodeCodeInterface
     */
    protected NodeCodeInterface $node;


    /**
     * @var ContextInterface
     */
    protected ContextInterface $context;

    /**
     * Information about the node
     *
     * @var string
     */
    protected string $notice = '';

    /**
     * @return NodeCodeInterface
     */
    public function getNode(): NodeCodeInterface
    {
        return $this->node;
    }

    /**
     * @param  NodeCodeInterface $node
     * @return ProcessNodeNotifyEvent
     */
    public function setNode(NodeCodeInterface $node): ProcessNodeNotifyEvent
    {
        $this->node = $node;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotice(): string
    {
        return $this->notice;
    }

    /**
     * @param  string $notice
     * @return ProcessNodeNotifyEvent
     */
    public function setNotice(string $notice): ProcessNodeNotifyEvent
    {
        $this->notice = $notice;
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
     * @param  ContextInterface $context
     * @return ProcessNodeNotifyEvent
     */
    public function setContext(ContextInterface $context): ProcessNodeNotifyEvent
    {
        $this->context = $context;
        return $this;
    }
}
