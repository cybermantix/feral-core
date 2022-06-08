<?php

namespace NoLoCo\Core\Process\Event\Listener;

use App\Utility\External\Slack\DataObject\Block\Exception\InvalidBlockException;
use App\Utility\External\Slack\DataObject\BlockInterface;
use App\Utility\External\Slack\DataObject\Composition\Text;
use App\Utility\External\Slack\DataObject\Message;
use App\Utility\External\Slack\DataObject\Surface\Surface;
use NoLoCo\Core\Process\Event\ProcessEndEvent;
use NoLoCo\Core\Process\Event\ProcessExceptionEvent;
use NoLoCo\Core\Process\Event\ProcessNodeAfterEvent;
use NoLoCo\Core\Process\Event\ProcessNodeBeforeEvent;
use NoLoCo\Core\Process\Event\ProcessNodeNotifyEvent;
use NoLoCo\Core\Process\Event\ProcessStartEvent;
use NoLoCo\Core\Process\Result\Result;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Utility\External\Slack\Facade;
use \App\Utility\External\Slack\BlockBuilder;

class SlackProcessSubscriber implements EventSubscriberInterface
{
    const ICON_URL = 'https://tribealpha.com/icons/dobbie-clock-trans.png';

    public function __construct(
        protected Facade $facade,
        protected BlockBuilder $builder,
        protected bool $onlyErrors = true
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            ProcessEndEvent::class => ['onEndProcess'],
            ProcessNodeAfterEvent::class => ['onAfterNode'],
            ProcessExceptionEvent::class => ['onProcessException'],
        ];
    }

    /**
     * @param ProcessEndEvent $event
     */
    public function onEndProcess(ProcessEndEvent $event)
    {
        if (!$this->onlyErrors) {
            $this->sendMarkdownMessage(sprintf(
                ':arrows_counterclockwise: Process Completed "%u" nodes.',
                count($event->getProcess()->getNodes())
            ));
        }
    }

    /**
     * @param ProcessNodeAfterEvent $event
     */
    public function onAfterNode(ProcessNodeAfterEvent $event)
    {
        $result = $event->getResult();
        if (Result::ERROR == $result->getStatus()) {
            $this->sendMarkdownMessage(sprintf(":bangbang: *Error*\n\n```%s```", $result->getMessage()));
        } elseif (!$this->onlyErrors && Result::WARNING == $result->getStatus()) {
            $this->sendMarkdownMessage(sprintf(":heavy_exclamation_mark: *Warning* \n\n```%s```", $result->getMessage()));
        }
    }

    /**
     * @param ProcessExceptionEvent $event
     */
    public function onProcessException(ProcessExceptionEvent $event)
    {
        $this->sendMarkdownMessage(sprintf(':interrobang: *Exception* "%s"',  $event->getThrowable()->getMessage()));
    }


    /**
     * @param string $markdown
     * @return bool
     * @throws InvalidBlockException
     */
    protected function sendMarkdownMessage(string $markdown, string $emoji = null): bool
    {
        $message = new Message();
        $message->addBlock(
            $this->builder
                ->initWithTypeForSurface(BlockInterface::CONTEXT, Surface::MESSAGE)
                ->addImage(self::ICON_URL, 'Ascendian Clock')
                ->addText($markdown, Text::MARKDOWN, $emoji)
                ->build()
        );
        return $this->facade->sendMessage($message);
    }
}
