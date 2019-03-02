<?php

declare(strict_types = 1);

namespace App\Domain\Screenshot;

use DateTimeImmutable;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Panther\Client as PantherClient;

class Client
{
    private $screenshotDir;

    public function __construct(string $screenshotDir)
    {
        $this->screenshotDir = rtrim($screenshotDir, '/');
    }

    public function takeScreenshot(string $url): Screenshot
    {
        $screenshot = new Screenshot();
        $screenshot->url = mb_strtolower($url);
        $filesystem = new Filesystem();
        if ($filesystem->exists($this->screenshotDir) === false) {
            $filesystem->mkdir($this->screenshotDir);
        }
        $urlDirectory = $this->createDirectoryFromUrl($screenshot->url);
        if ($filesystem->exists($urlDirectory) === false) {
            $filesystem->mkdir($urlDirectory);
        }
        $screenshot->createdOn = new DateTimeImmutable();
        $screenshot->filename = sprintf('%s/%s.png', $urlDirectory, $screenshot->createdOn->getTimestamp());

        $driver = PantherClient::createChromeClient();
        $driver->get($url)->takeScreenshot($screenshot->filename);
        $driver->close();

        return $screenshot;
    }

    private function createDirectoryFromUrl(string $url): string
    {
        $url = sprintf(
            '%s/%s',
            $this->screenshotDir,
            iconv(mb_detect_encoding($url), 'ISO-8859-1//TRANSLIT', parse_url($url, PHP_URL_HOST))
        );
        $path = parse_url($url, PHP_URL_PATH);
        if ($path !== null) {
            $url .= rtrim(iconv(mb_detect_encoding($url), 'ISO-8859-1//TRANSLIT', $path), '/');
        }

        return $url;
    }
}
