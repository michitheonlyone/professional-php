<?php declare(strict_types=1);

namespace Socialnews\User\Presentation;

use Socialnews\Framework\Rendering\TemplateRenderer;
use Socialnews\User\Application\RegisterUserFormFactory;
use Socialnews\User\Application\RegisterUserHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

final class RegistrationController
{
    private $templateRenderer;
    private $registerUserFormFactory;
    private $session;
    private $registerUserHandler;

    public function __construct(
        TemplateRenderer $templateRenderer,
        RegisterUserFormFactory $registerUserFormFactory,
        Session $session,
        RegisterUserHandler $registerUserHandler
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->registerUserFormFactory = $registerUserFormFactory;
        $this->session = $session;
        $this->registerUserHandler = $registerUserHandler;
    }

    public function show(): Response
    {
        $content = $this->templateRenderer->render('Registration.html.twig');
        return new Response($content);
    }

    public function register(Request $request): Response
    {
        $response = new RedirectResponse('/register');
        $form = $this->registerUserFormFactory->createFromRequest($request);
        if ($form->hasValidationErrors()) {
            foreach ($form->getValidationErrors() as $errorMessage) {
                $this->session->getFlashBag()->add('errors', $errorMessage);
            }
            return $response;
        }
        $this->registerUserHandler->handle($form->toCommand());
        $this->session->getFlashBag()->add('success', 'User Registration comlete! you can now log in');
        return new RedirectResponse('/login');
    }
}