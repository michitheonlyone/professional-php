<?php declare(strict_types=1);

namespace Socialnews\Framework\Csrf;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SymfonySessionTokenStorage implements TokenStorage
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function store(string $key, Token $token): void
    {
        $this->session->set($key, $token->toString());
    }

    public function retrieve(string $key): ?Token
    {
        $tokenValue = $this->session->get($key);

        if ($tokenValue === null) {
            return null;
        }

        return new Token($tokenValue);
    }
}