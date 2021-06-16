<?php declare(strict_types=1);

namespace Socialnews\User\Presentation;

use Socialnews\Framework\Rendering\TemplateRenderer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Socialnews\Framework\Csrf\StoredTokenValidator;
use Socialnews\Framework\Csrf\Token;
use Socialnews\User\Application\LoginHandler;
use Socialnews\User\Application\LogIn;

final class LoginController
{
    private $templateRenderer;
    private $storedTokenValidator;
    private $session;
    private $loginHandler;

    public function __construct(
        TemplateRenderer $templateRenderer,
        StoredTokenValidator $storedTokenValidator,
        Session $session,
        LoginHandler $loginHandler
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->storedTokenValidator = $storedTokenValidator;
        $this->session = $session;
        $this->loginHandler = $loginHandler;
    }

    public function show(): Response
    {
        $content = $this->templateRenderer->render('Login.html.twig');
        return new Response($content);
    }

    public function login(Request $request): Response
    {
        if (!$this->storedTokenValidator->validate('login', new Token((string)$request->get('token')))) {
            $this->session->getFlashBag()->add('errors', 'invalid token');
            return new RedirectResponse('/login');
        }

        $this->loginHandler->handle(new LogIn(
            (string)$request->get('nickname'),
            (string)$request->get('password')
        ));

        if ($this->session->get('userId') === null) {
            $this->session->getFlashBag()->add('errors', 'Invalid Username or Password');
            return new RedirectResponse('/login');
        }

//        $this->session->remove('userId'); // TODO: Login überprüfen weshalb remove hier???

        $this->session->getFlashBag()->add('success','you are logged in');
        return new RedirectResponse('/');
    }
}