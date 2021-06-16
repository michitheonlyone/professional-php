<?php

namespace Socialnews\User\Presentation;

use Socialnews\Framework\Csrf\StoredTokenValidator;
use Socialnews\Framework\Csrf\Token;
use Socialnews\User\Application\NicknameTakenQuery;
use Socialnews\User\Application\RegisterUser;

//use Socialnews\Submission\Application\SubmitLink;

final class RegisterUserForm
{
    private $storedTokenValidator;
    private $nicknameTakenQuery;
    private $token;
    private $nickname;
    private $password;

    public function __construct(
        StoredTokenValidator $storedTokenValidator,
        NicknameTakenQuery $nicknameTakenQuery,
        string $token,
        string $nickname,
        string $password
    ) {
        $this->storedTokenValidator = $storedTokenValidator;
        $this->nicknameTakenQuery = $nicknameTakenQuery;
        $this->token = $token;
        $this->nickname = $nickname;
        $this->password = $password;
    }

    public function getValidationErrors(): array
    {
        $errors = [];

        if (!$this->storedTokenValidator->validate(
            'registration',
            new Token($this->token)
        )) {
            $errors[] = 'invalid token';
        }

        if ($this->nicknameTakenQuery->execute($this->nickname)) {
            $errors[] = 'nickname has been taken';
        }

        if (strlen($this->nickname) < 3 || strlen($this->nickname) > 20) {
            $errors[] = 'Nickname must be between 3 and 20 characters';
        }

        if (!ctype_alnum($this->nickname)) {
            $errors[] = 'Nickname can only consist of letters and numbers';
        }

        if (strlen($this->password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }

        return $errors;
    }

    public function hasValidationErrors(): bool
    {
        return (count($this->getValidationErrors()) > 0);
    }

    public function toCommand(): RegisterUser
    {
        return new RegisterUser($this->nickname, $this->password);
    }
}