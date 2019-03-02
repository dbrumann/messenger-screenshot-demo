<?php

declare(strict_types = 1);

namespace App\Domain\Screenshot;

use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SaveScreenshotHandler implements MessageHandlerInterface
{
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    public function __invoke(ScreenshotTakenEvent $event)
    {
        $manager = $this->managerRegistry->getManager();
        $manager->persist(\App\Entity\Screenshot::fromDto($event->getScreenshot()));
        $manager->flush();
    }
}
