<?php

declare(strict_types = 1);

namespace App\Domain\Screenshot;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class TakeScreenshotHandler implements MessageHandlerInterface
{
    private $messageBus;
    private $client;

    public function __construct(MessageBusInterface $messageBus, Client $client)
    {
        $this->messageBus = $messageBus;
        $this->client = $client;
    }

    public function __invoke(TakeScreenshotCommand $takeScreenshot)
    {
        $screenshotGenerator = $this->client->takeScreenshots($takeScreenshot->getUrls());

        while ($screenshotGenerator->valid()) {
            $screenshot = $screenshotGenerator->current();

            $this->messageBus->dispatch(new ScreenshotTakenEvent($screenshot));

            $screenshotGenerator->next();
        }
    }
}
