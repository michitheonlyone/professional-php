<?php declare(strict_types=1);

namespace Socialnews\Submission\Application;

use Socialnews\Submission\Domain\SubmissionRepository;
use Socialnews\Submission\Domain\Submission;

final class SubmitLinkHandler
{
    private $submissionRepository;

    public function __construct(SubmissionRepository $submissionRepository)
    {
        $this->submissionRepository = $submissionRepository;
    }

    public function handle(SubmitLink $command): void
    {
        $submission = Submission::submit(
            $command->getUrl(),
            $command->getTitle()
        );
        $this->submissionRepository->add($submission);
    }
}