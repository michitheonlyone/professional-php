<?php declare(strict_types=1);

namespace Socialnews\Submission\Presentation;

use Socialnews\Framework\Rbac\User;
use Socialnews\Framework\Rendering\TemplateRenderer;
use Socialnews\Submission\Application\SubmitLinkHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Socialnews\Framework\Rbac\Permission;

final class SubmissionController
{
    private $templateRenderer;
    private $submissionFormFactory;
    private $session;
    private $submitLinkHandler;
    private $user;

    public function __construct(
        TemplateRenderer $templateRenderer,
        SubmissionFormFactory $submissionFormFactory,
        Session $session,
        SubmitLinkHandler $submitLinkHandler,
        User $user
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->submissionFormFactory = $submissionFormFactory;
        $this->session = $session;
        $this->submitLinkHandler = $submitLinkHandler;
        $this->user = $user;
    }

    public function show(): Response
    {
        if (!$this->user->hasPermission(new Permission\SubmitLink())) {
            $this->session->getFlashBag()->add('errors', 'You need to login in order to submiet links');
            return new RedirectResponse('/login');
        }
        $content = $this->templateRenderer->render('Submissions.html.twig');
        return new Response($content);
    }

    public function submit(Request $request): Response
    {
        if (!$this->user->hasPermission(new Permission\SubmitLink())) {
            $this->session->getFlashBag()->add('errors', 'You need to login in order to submiet links');
            return new RedirectResponse('/login');
        }
        $response = new RedirectResponse('/submit');
        $form = $this->submissionFormFactory->createFromRequest($request);
        if ($form->hasValidationErrors()) {
            foreach ($form->getValidationErrors() as $errorMessage) {
                $this->session->getFlashBag()->add('errors', $errorMessage);
            }
            return $response;
        }
        $this->submitLinkHandler->handle($form->toCommand());
        $this->session->getFlashBag()->add('success', 'Your URL has saved!');
        return $response;
    }
}