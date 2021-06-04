<?php declare(strict_types=1);

namespace Socialnews\Frontpage\Infrastructure;

use Socialnews\Frontpage\Application\Submission;
use Socialnews\Frontpage\Application\SubmissionsQuery;

final class MockSubmissionsQuery implements SubmissionsQuery
{
    private $submissions;

    public function __construct()
    {
        $this->submissions = [
            new Submission('http://www.google.com', 'Google'),
            new Submission('http://www.duckduckgo.com', 'DuckDuck Go'),
            new Submission('http://www.bing.com', 'Bing')
        ];
    }

    public function execute(): array
    {
        return $this->submissions;
    }
}