<?php declare(strict_types=1);

namespace Socialnews\Framework\Rbac;

interface User
{
    public function hasPermission(Permission $permission): bool;
}