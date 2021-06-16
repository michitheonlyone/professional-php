<?php declare(strict_types=1);

namespace Socialnews\Framework\Rbac;

final class Guest implements User
{
    public function hasPermission(Permission $permission): bool
    {
        return false;
    }
}