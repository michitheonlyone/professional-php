<?php declare(strict_types=1);

namespace Socialnews\Frontpage\Presentation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Socialnews\Framework\Rendering\TemplateRenderer;

final class FrontPageController
{
    public function __construct(TemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function show(Request $request) : Response
    {
        $submissions = [
            ['url' => 'https://google.com', 'title' => 'Google'],
            ['url' => 'https://bing.com', 'title' => 'Bing']
        ];
        $content = $this->templateRenderer->render('FrontPage.html.twig',
            ['submissions' => $submissions]
        );
        return new Response($content);
    }
}