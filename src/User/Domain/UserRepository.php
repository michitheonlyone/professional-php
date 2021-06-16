<?php declare(strict_types=1);

namespace Socialnews\User\Domain;

interface UserRepository
{
    public function add(User $user): void;
    public function save(User $user): void;
    public function findByNickName(string $nickname): ?User;
}