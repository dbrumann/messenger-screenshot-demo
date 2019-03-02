<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Domain\Screenshot\Client;
use App\Entity\Screenshot;
use Doctrine\Common\Persistence\ManagerRegistry;
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
    private $managerRegistry;

    public function __construct(Environment $twig, UrlGeneratorInterface $urlGenerator, ManagerRegistry $managerRegistry)
    {
        $this->twig = $twig;
        $this->urlGenerator = $urlGenerator;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route(path="/screenshots", methods={"GET", "POST"}, name="screenshots_take")
     */
    public function __invoke(Client $screenshotClient, Request $request): Response
    {
        if ($request->isMethod('post')) {
            $screenshot = $screenshotClient->takeScreenshot($request->request->get('screenshotUrl'));

            $manager = $this->managerRegistry->getManager();
            $manager->persist(Screenshot::fromDto($screenshot));
            $manager->flush();

            return new RedirectResponse($this->urlGenerator->generate('screenshots_browse'));
        }

        return new Response($this->twig->render('screenshots/take.html.twig'));
    }
}
