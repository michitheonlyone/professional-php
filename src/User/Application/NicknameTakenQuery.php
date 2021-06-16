<?php declare(strict_types=1);

namespace Socialnews\User\Application;

interface NicknameTakenQuery
{
    public function execute(string $nickname): bool;
}