<?php declare(strict_types=1);

namespace Socialnews\Submission\Domain;

interface SubmissionRepository
{
    public function add(Submission $submission): void;
}