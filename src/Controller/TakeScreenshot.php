<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Screenshot\Client;
use App\Domain\Screenshot\TakeScreenshotEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class TakeScreenshot
{
    private $twig;
    private $urlGenerator;
    private $eventDispatcher;

    public function __construct(Environment $twig, UrlGeneratorInterface $urlGenerator, EventDispatcherInterface $eventDispatcher)
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route(path="/screenshots", methods={"GET", "POST"}, name="screenshots_take")
     */
    public function __invoke(Client $screenshotClient, Request $request): Response
    {
        if ($request->isMethod('post')) {
            $this->eventDispatcher->dispatch(
                'app.take_screenshot',
                new TakeScreenshotEvent($request->request->get('screenshotUrl'))
            );

            return new RedirectResponse($this->urlGenerator->generate('screenshots_browse'));
        }

        return new Response($this->twig->render('screenshots/take.html.twig'));
    }
}
