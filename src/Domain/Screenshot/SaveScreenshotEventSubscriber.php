<?php

declare(strict_types = 1);

namespace App\Domain\Screenshot;

use App\Entity\Screenshot as ScreenshotEntity;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SaveScreenshotEventSubscriber implements EventSubscriberInterface
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public static function getSubscribedEvents()
    {
        return [
            'app.save_screenshot' => ['saveScreenshot'],
        ];
    }

    public function saveScreenshot(SaveScreenshotEvent $event)
    {
        $manager = $this->managerRegistry->getManager();

        $manager->persist(ScreenshotEntity::fromDto($event->getScreenshot()));
        $manager->flush();
    }
}
