<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

final class Migration202104061429
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function migrate(): void
    {
        $schema = new Schema();
        $this->createSubmissionTable($schema);

        $queries = $schema->toSql($this->connection->getDatabasePlatform());
        foreach ($queries as $query) {
            $this->connection->executeQuery($query);
        }
    }

    private function createSubmissionTable(Schema $schema): void
    {
        $table = $schema->createTable('submissions');
        $table->addColumn('id', 'guid');
        $table->addColumn('title', 'string');
        $table->addColumn('url', 'string');
        $table->addColumn('creation_date', 'datetime');
//        $table->addColumn('test', 'string');
    }
}