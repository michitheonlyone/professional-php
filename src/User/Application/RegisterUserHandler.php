<?php declare(strict_types=1);

namespace Socialnews\User\Application;

use Socialnews\User\Domain\User;
use Socialnews\User\Domain\UserRepository;

final class RegisterUserHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(RegisterUser $command): void
    {
        $user = User::register(
            $command->getNickname(),
            $command->getPassword()
        );
        $this->userRepository->add($user);
    }
}