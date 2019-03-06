<?php

declare(strict_types = 1);

namespace App\Domain\Screenshot;

use Symfony\Component\Validator\Constraints as Assert;

class TakeScreenshotCommand
{
    /**
     * @Assert\All({
     *     @Assert\Url()
     * })
     */
    private $urls;

    public function __construct(string ...$urls)
    {
        $this->urls = $urls;
    }

    public function setUrls(array $urls)
    {
        $this->urls = $urls;
    }

    public function getUrls(): array
    {
        return $this->urls;
    }
}
