<?php

declare(strict_types = 1);

namespace App\Domain\Screenshot;

use Symfony\Component\EventDispatcher\Event;

class SaveScreenshotEvent extends Event
{
    private $screenshot;

    public function __construct(Screenshot $screenshot)
    {
        $this->screenshot = $screenshot;
    }

    public function getScreenshot(): Screenshot
    {
        return $this->screenshot;
    }
}
