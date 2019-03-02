<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Repository\ScreenshotRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class BrowseScreenshots
{
    private $twig;
    private $screenshotRepository;

    public function __construct(Environment $twig, ScreenshotRepository $screenshotRepository)
    {
        $this->twig = $twig;
        $this->screenshotRepository = $screenshotRepository;
    }

    /**
     * @Route(path="/", methods={"GET"}, name="screenshots_browse")
     */
    public function __invoke(string $screenshotDir): Response
    {
        return new Response(
            $this->twig->render(
                'screenshots/browse.html.twig',
                [
                    'screenshots' => $this->screenshotRepository->findAllScreenshots(),
                ]
            )
        );
    }
}
