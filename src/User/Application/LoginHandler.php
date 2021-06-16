<?php declare(strict_types=1);

namespace Socialnews\User\Application;

use Socialnews\User\Domain\UserRepository;

final class LoginHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(LogIn $command): void
    {
        $user = $this->userRepository->findByNickName($command->getNickname());

        if ($user === null) {
            return;
        }

        $user->logIn($command->getPassword());
        $this->userRepository->save($user);
    }

}