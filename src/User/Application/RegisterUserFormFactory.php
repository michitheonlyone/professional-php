<?php declare(strict_types=1);

namespace Socialnews\User\Application;

use Socialnews\Framework\Csrf\StoredTokenValidator;
use Socialnews\User\Presentation\RegisterUserForm;
use Symfony\Component\HttpFoundation\Request;

final class RegisterUserFormFactory
{
    private $storedTokenValidator;
    private $nicknameTakenQuery;

    public function __construct(StoredTokenValidator $storedTokenValidator, NicknameTakenQuery $nicknameTakenQuery)
    {
        $this->storedTokenValidator = $storedTokenValidator;
        $this->nicknameTakenQuery = $nicknameTakenQuery;
    }

    public function createFromRequest(Request $request): RegisterUserForm
    {
        return new RegisterUserForm(
            $this->storedTokenValidator,
            $this->nicknameTakenQuery,
            $request->get('token'),
            $request->get('nickname'),
            $request->get('password')
        );
    }
}