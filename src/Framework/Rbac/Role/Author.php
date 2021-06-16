<?php declare(strict_types=1);

namespace Socialnews\Framework\Rbac\Role;

use Socialnews\Framework\Rbac\Permission\SubmitLink;
use Socialnews\Framework\Rbac\Role;

final class Author extends Role
{
    protected function getPermissions(): array
    {
        return [new SubmitLink()];
    }
}