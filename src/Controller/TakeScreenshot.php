<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Screenshot\Client;
use App\Domain\Screenshot\TakeScreenshotCommand;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class TakeScreenshot
{
    private $twig;
    private $urlGenerator;
    private $messageBus;

    public function __construct(Environment $twig, UrlGeneratorInterface $urlGenerator, MessageBusInterface $messageBus)
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->messageBus = $messageBus;
    }

    /**
     * @Route(path="/screenshots", methods={"GET", "POST"}, name="screenshots_take")
     */
    public function __invoke(Client $screenshotClient, Request $request): Response
    {
        if ($request->isMethod('post')) {
            $this->messageBus->dispatch(
                new TakeScreenshotCommand($request->request->get('screenshotUrl'))
            );

            return new RedirectResponse($this->urlGenerator->generate('screenshots_browse'));
        }

        return new Response($this->twig->render('screenshots/take.html.twig'));
    }
}
