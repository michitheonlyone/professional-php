<?php declare(strict_types=1);

namespace Socialnews\Framework\Rbac;

interface CurrentUserFactory
{
    public function create(): User;
}