<?php declare(strict_types=1);

namespace Socialnews\Submission\Infrastructure;

use Doctrine\DBAL\Connection;
use Socialnews\Submission\Domain\Submission;
use Socialnews\Submission\Domain\SubmissionRepository;

final class DbalSubmissionRepository implements SubmissionRepository
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function add(Submission $submission): void
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->insert('submissions');
        $qb->values([
            'id' => $qb->createNamedParameter($submission->getId()->toString()),
            'url' => $qb->createNamedParameter($submission->getUrl()),
            'title' => $qb->createNamedParameter($submission->getTitle()),
            'creation_date' => $qb->createNamedParameter($submission->getCreationDate(),'datetime')
        ]);
        $qb->executeQuery();
    }
}