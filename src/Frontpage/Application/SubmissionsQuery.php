<?php declare(strict_types=1);

namespace Socialnews\Frontpage\Application;

interface SubmissionsQuery
{
    public function execute(): array;
}