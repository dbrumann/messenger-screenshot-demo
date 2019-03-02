<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Repository\ScreenshotRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class GetScreenshot
{
    private $screenshotRepository;

    public function __construct(ScreenshotRepository $screenshotRepository)
    {
        $this->screenshotRepository = $screenshotRepository;
    }

    /**
     * @Route(path="/screenshots/{id}", methods={"GET"}, name="screenshots_get")
     */
    public function __invoke(string $id): Response
    {
        $screenshot = $this->screenshotRepository->findScreenshot($id);
        if (null === $screenshot) {
            return new NotFoundHttpException(sprintf('Could not find screenshot with id "%s"', $id));
        }

        return new BinaryFileResponse($screenshot->getScreenshot()->getPathname());
    }
}
