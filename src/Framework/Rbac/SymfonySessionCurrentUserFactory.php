<?php declare(strict_types=1);

namespace Socialnews\Framework\Rbac;

use Ramsey\Uuid\Uuid;
use Socialnews\Framework\Rbac\Role\Author;
use Symfony\Component\HttpFoundation\Session\Session;

final class SymfonySessionCurrentUserFactory implements CurrentUserFactory
{
    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function create(): User
    {
        if (!$this->session->has('userId')) {
            return new Guest();
        }

        return new AuthenticatedUser(
            Uuid::fromString($this->session->get('userId')),
            [new Author()]
        );
    }
}