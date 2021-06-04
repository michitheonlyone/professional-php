<?php declare(strict_types=1);

namespace Socialnews\Frontpage\Infrastructure;

use Doctrine\DBAL\Connection;
use Socialnews\Frontpage\Application\Submission;
use Socialnews\Frontpage\Application\SubmissionsQuery;


class DbalSubmissionsQuery implements SubmissionsQuery
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function execute(): array
    {
        $db = $this->connection->createQueryBuilder();

        $db->addSelect('title');
        $db->addSelect('url');
        $db->from('submissions');
        $db->orderBy('creation_date', 'DESC');

        $stm = $db->executeQuery();
        $rows = $stm->fetchAllAssociative();

        $submissions = [];
        foreach ($rows as $row) {
            $submissions[] = new Submission($row['url'], $row['title']);
        }

        return $submissions;
    }
}