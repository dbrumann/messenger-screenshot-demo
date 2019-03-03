<?php

declare(strict_types = 1);

namespace App\Domain\Screenshot;

use Symfony\Component\EventDispatcher\Event;

class TakeScreenshotEvent extends Event
{
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
