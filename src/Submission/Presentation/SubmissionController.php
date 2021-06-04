<?php declare(strict_types=1);

namespace Socialnews\Submission\Presentation;

use Socialnews\Framework\Csrf\StoredTokenValidator;
use Socialnews\Framework\Rendering\TemplateRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SubmissionController
{
    private $templateRenderer;
    private $storedTokenValidator;

    public function __construct(
        TemplateRenderer $templateRenderer,
        StoredTokenValidator $storedTokenValidator
    ){
        $this->templateRenderer = $templateRenderer;
        $this->storedTokenValidator = $storedTokenValidator;
    }

    public function show() : Response
    {
        $content = $this->templateRenderer->render('Submissions.html.twig');
        return new Response($content);
    }

    public function submit(Request $request) : Response
    {
        $content = $request->get('title') . '-' . $request->get('url');
        return new Response($content);
    }
}