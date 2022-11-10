<?php

namespace NoLoCo\Core\Process\Event\Listener;

use NoLoCo\Core\Process\Event\ProcessEndEvent;
use NoLoCo\Core\Process\Event\ProcessExceptionEvent;
use NoLoCo\Core\Process\Event\ProcessNodeAfterEvent;
use NoLoCo\Core\Process\Event\ProcessNodeBeforeEvent;
use NoLoCo\Core\Process\Event\ProcessNodeNotifyEvent;
use NoLoCo\Core\Process\Event\ProcessStartEvent;
use NoLoCo\Core\Process\Result\Result;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoggerProcessSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected LoggerInterface $logger
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ProcessStartEvent::class => ['onStartProcess'],
            ProcessEndEvent::class => ['onEndProcess'],
            ProcessNodeBeforeEvent::class => ['onBeforeNode'],
            ProcessNodeAfterEvent::class => ['onAfterNode'],
            ProcessExceptionEvent::class => ['onProcessException'],
            ProcessNodeNotifyEvent::class => ['onNodeNotify'],
        ];
    }

    /**
     * @param ProcessStartEvent $event
     */
    public function onStartProcess(ProcessStartEvent $event)
    {
        $this->logger->info(
            'Starting a process with {cnt} nodes.',
            ['cnt' => count($event->getProcess()->getNodes())]
        );
    }

    /**
     * @param ProcessEndEvent $event
     */
    public function onEndProcess(ProcessEndEvent $event)
    {
        $this->logger->info('Process Complete');
    }

    /**
     * @param ProcessNodeBeforeEvent $event
     */
    public function onBeforeNode(ProcessNodeBeforeEvent $event)
    {
        $this->logger->info(
            'Processing Node {key}',
            ['key' => $event->getNode()->getKey()]
        );
    }

    /**
     * @param ProcessNodeAfterEvent $event
     */
    public function onAfterNode(ProcessNodeAfterEvent $event)
    {
        $result = $event->getResult();
        if (Result::ERROR == $result->getStatus()) {
            $this->logger->error(
                'Process resulted with status "{status}" and message "{message}".',
                [
                    'status' => $result->getStatus(),
                    'message' => $result->getMessage()
                ]
            );
        } elseif (Result::WARNING == $result->getStatus()) {
            $this->logger->warning(
                'Process resulted with status "{status}" and message "{message}".',
                [
                    'status' => $result->getStatus(),
                    'message' => $result->getMessage()
                ]
            );
        }else {
            $this->logger->debug(
                'Process resulted with status "{status}" and message "{message}".',
                [
                    'status' => $result->getStatus(),
                    'message' => $result->getMessage()
                ]
            );
        }
    }

    /**
     * @param ProcessExceptionEvent $event
     */
    public function onProcessException(ProcessExceptionEvent $event)
    {
        $this->logger->error(
            'Process node {node} threw an exception: {message}.',
            [
                'node' => $event->getNode()->getNodeKey(),
                'message' => $event->getThrowable()->getMessage()
            ]
        );
    }

    /**
     * @param ProcessNodeNotifyEvent $event
     */
    public function onNodeNotify(ProcessNodeNotifyEvent $event)
    {
        $this->logger->info(
            'Node {key}, {note}',
            [
                'key' => $event->getNode()->getNodeKey(),
                'note' => $event->getNotice()
            ]
        );
    }
}
