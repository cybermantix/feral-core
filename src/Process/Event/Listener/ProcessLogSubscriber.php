<?php

namespace NoLoCo\Core\Process\Event\Listener;

use App\Builder\Core\ProcessLog\V01\ProcessLogBuilder;
use App\Builder\Core\ProcessLog\V01\ProcessLogMessageBuilder;
use App\Builder\Exception\BuilderException;
use App\Entity\Accounts\V01\Store;
use App\Entity\Core\Process\V01\Process;
use App\Entity\Core\Process\V01\ProcessLog;
use App\Messages\Core\Process\V01\ProcessLogMessage;
use NoLoCo\Core\Process\Context\Context;
use NoLoCo\Core\Process\Event\ProcessEndEvent;
use NoLoCo\Core\Process\Event\ProcessExceptionEvent;
use NoLoCo\Core\Process\Event\ProcessNodeAfterEvent;
use NoLoCo\Core\Process\Event\ProcessNodeNotifyEvent;
use NoLoCo\Core\Process\Event\ProcessStartEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Add information about the process to the database so the process
 * can be tracked and viewed. The context must contain an instance
 * id to log the process.
 *
 * @see ProcessLog::CONTEXT_NAME_KEY
 * @see Store::CONTEXT_KEY
 * @package NoLoCo\Core\Process\Event\Listener
 */
class ProcessLogSubscriber implements EventSubscriberInterface
{
    /**
     * @var ProcessLog[]
     */
    protected array $processLogs = [];

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected ProcessLogBuilder $builder,
        protected MessageBusInterface $messageBus
    ) {
    }

    public function __destruct()
    {
        $this->sendLogs();
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            ProcessStartEvent::class => ['onStartProcess'],
            ProcessEndEvent::class => ['onEndProcess'],
            ProcessNodeAfterEvent::class => ['onAfterNode'],
            ProcessExceptionEvent::class => ['onProcessException'],
            ProcessNodeNotifyEvent::class => ['onNodeNotify']
        ];
    }

    /**
     * @param ProcessStartEvent $event
     * @throws BuilderException
     */
    public function onStartProcess(ProcessStartEvent $event)
    {
        if ($event->getContext()->has(Process::CONTEXT_INSTANCE_ID)) {
            $log = $this->builder
                ->init()
                ->start()
                ->appendNotes('Starting Process')
                ->build();
            $this->persistAndFlush($event->getContext(), $log);
        }
    }

    /**
     * @param ProcessEndEvent $event
     */
    public function onEndProcess(ProcessEndEvent $event)
    {
        if ($event->getContext()->has(Process::CONTEXT_INSTANCE_ID)) {
            $log = $this->builder
                ->init()
                ->complete('Process Complete')
                ->build();
            $this->persistAndFlush($event->getContext(), $log);
            $this->sendLogs();
        }
    }

    /**
     * @param ProcessNodeAfterEvent $event
     */
    public function onAfterNode(ProcessNodeAfterEvent $event)
    {
        if ($event->getContext()->has(Process::CONTEXT_INSTANCE_ID)) {
            $log = $this->builder
                ->init()
                ->update(sprintf(
                    'Result (%s) %s',
                    $event->getResult()->getStatus(),
                    $event->getResult()->getMessage()
                ))
                ->build();
            $this->persistAndFlush($event->getContext(), $log);
        }
    }

    /**
     * @param ProcessExceptionEvent $event
     */
    public function onProcessException(ProcessExceptionEvent $event)
    {
        if ($event->getContext()->has(Process::CONTEXT_INSTANCE_ID)) {
            $log = $this->builder
                ->init()
                ->error($event->getThrowable()->getMessage())
                ->build();
            $this->persistAndFlush($event->getContext(), $log);
        }
    }

    /**
     * @param ProcessNodeNotifyEvent $event
     */
    public function onNodeNotify(ProcessNodeNotifyEvent $event)
    {
        if ($event->getContext()->has(Process::CONTEXT_INSTANCE_ID)) {
            $log = $this->builder
                ->init()
                ->update($event->getNotice())
                ->build();
            $this->persistAndFlush($event->getContext(), $log);
        }
    }

    /**
     * Persist and flush only the current ProcessLog entity.
     */
    protected function persistAndFlush(Context $context, ProcessLog $log)
    {
        $this->builder->init($log);
        $processInstanceId = $context->get(Process::CONTEXT_INSTANCE_ID);
        if ($processInstanceId) {
            $this->builder->withProcessInstanceId($processInstanceId);
        }
        $processAlias = $context->get(Process::CONTEXT_ALIAS);
        if ($processAlias) {
            $this->builder->withAlias($processAlias);
        } else {
            return;
        }
        $store = $context->get(Store::CONTEXT_KEY);
        if ($store) {
            $this->builder->withStore($store);
        }
        $this->processLogs[] = $this->builder->build();
    }

    protected function sendLogs(): void
    {
        $processLogMessage = (new ProcessLogMessage())
            ->setProcessLogs($this->processLogs);
        $this->messageBus->dispatch($processLogMessage);
        $this->processLogs = [];
    }
}
