<?php

declare(strict_types = 1);

namespace App\Entity;

use App\Domain\Screenshot\Screenshot as ScreenshotDto;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScreenshotRepository")
 */
class Screenshot
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column()
     */
    private $url;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdOn;

    /**
     * @ORM\Column(type="string")
     */
    private $screenshot;

    private function __construct(string $url, string $screenshotFilename, DateTimeImmutable $created)
    {
        $this->id = Uuid::uuid4();
        $this->url = $url;
        $this->screenshot = $screenshotFilename;
        $this->createdOn = $created;
    }

    public static function fromDto(ScreenshotDto $dto): self
    {
        return new static($dto->url, $dto->filename, new DateTimeImmutable("@{$dto->createdOn}"));
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCreatedOn(): \DateTimeImmutable
    {
        return $this->createdOn;
    }

    public function getScreenshot(): File
    {
        return new File($this->screenshot);
    }
}
