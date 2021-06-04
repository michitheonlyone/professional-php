<?php declare(strict_types=1);

namespace Socialnews\Frontpage\Presentation;

use Socialnews\Frontpage\Application\SubmissionsQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Socialnews\Framework\Rendering\TemplateRenderer;

final class FrontPageController
{
    public function __construct(
        TemplateRenderer $templateRenderer,
        SubmissionsQuery $submissionsQuery
    )  {
        $this->templateRenderer = $templateRenderer;
        $this->submissionsquery = $submissionsQuery;
    }

    public function show(Request $request) : Response
    {
        $content = $this->templateRenderer->render('FrontPage.html.twig',
            ['submissions' => $this->submissionsquery->execute()]
        );
        return new Response($content);
    }
}