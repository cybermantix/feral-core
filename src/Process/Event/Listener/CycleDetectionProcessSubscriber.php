<?php

namespace NoLoCo\Core\Process\Event\Listener;

use NoLoCo\Core\Process\Event\ProcessEndEvent;
use NoLoCo\Core\Process\Event\ProcessNodeBeforeEvent;
use NoLoCo\Core\Process\Event\ProcessStartEvent;
use NoLoCo\Core\Process\Exception\MaximumNodeRunsException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class CycleDetectionProcessSubscriber
 * @package NoLoCo\Core\Process\Event\Listener
 */
class CycleDetectionProcessSubscriber implements EventSubscriberInterface
{
    public const DEFAULT_MAXIMUM_VISITS = 5;
    public const CONTEXT_KEY_MAXIMUM_VISITS = 'maximum_visits';

    protected array $nodeVisits = [];

    public function __construct(
        protected int $maximumVisits = self::DEFAULT_MAXIMUM_VISITS
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ProcessStartEvent::class => ['onStartProcess'],
            ProcessNodeBeforeEvent::class => ['onBeforeNode']
        ];
    }

    public function onStartProcess(Event $event)
    {
        $this->nodeVisits = [];
    }

    /**
     * @param Event|ProcessNodeBeforeEvent $event
     */
    public function onBeforeNode(Event $event)
    {
        $instanceMaximumVisits = $this->maximumVisits;
        $context = $event->getContext();
        if ($context->has(self::CONTEXT_KEY_MAXIMUM_VISITS)) {
            $maximumVisits = $context->getInt(self::CONTEXT_KEY_MAXIMUM_VISITS);
            if (0 >= $maximumVisits) {
                return;
            } else {
                $instanceMaximumVisits = $maximumVisits;
            }
        }

        $key = $event->getNode()->getKey();
        if (!isset($this->nodeVisits[$key])) {
            $this->nodeVisits[$key] = 0;
        }
        $this->nodeVisits[$key]++;
        if ($this->nodeVisits[$key] > $instanceMaximumVisits) {
            throw new MaximumNodeRunsException(sprintf(
                'Maximum number of runs "%u" on process node "%s" has been reached.',
                $this->maximumVisits,
                $key
            ));
        }
    }
}
