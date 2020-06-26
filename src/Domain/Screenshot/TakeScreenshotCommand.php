<?php

declare(strict_types = 1);

namespace App\Domain\Screenshot;

class TakeScreenshotCommand
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
