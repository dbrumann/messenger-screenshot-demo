<?php

declare(strict_types = 1);

namespace App\Domain\Screenshot;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TakeScreenshotEventSubscriber implements EventSubscriberInterface
{
    private $client;
    private $eventDispatcher;

    public function __construct(Client $client, EventDispatcherInterface $eventDispatcher)
    {
        $this->client = $client;
        $this->eventDispatcher = $eventDispatcher;
    }

    public static function getSubscribedEvents()
    {
        return [
            'app.take_screenshot' => ['takeScreenshot'],
        ];
    }

    public function takeScreenshot(TakeScreenshotEvent $event)
    {
        $screenshot = $this->client->takeScreenshot($event->getUrl());

        $this->eventDispatcher->dispatch('app.save_screenshot', new SaveScreenshotEvent($screenshot));
    }
}
