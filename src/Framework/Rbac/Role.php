<?php declare(strict_types=1);

namespace Socialnews\Framework\Rbac;

abstract class Role
{
    public function hasPermission(Permission $permission): bool
    {
        return in_array($permission, $this->getPermissions());
    }

    abstract protected function getPermissions(): array;
}