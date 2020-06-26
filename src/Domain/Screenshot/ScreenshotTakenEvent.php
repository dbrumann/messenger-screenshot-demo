<?php

declare(strict_types = 1);

namespace App\Domain\Screenshot;

class ScreenshotTakenEvent
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
