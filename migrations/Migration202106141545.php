<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;

final class Migration202106141545
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
        $table = $schema->createTable('users');
        $table->addColumn('id', Types::GUID);
        $table->addColumn('nickname', Types::STRING);
        $table->addColumn('password_hash', Types::STRING);
        $table->addColumn('creation_date', Types::DATETIME_MUTABLE);
        $table->addColumn('failed_login_attempts', Types::INTEGER, ['default' => 0]);
        $table->addColumn('last_failed_login_attempt', Types::DATETIME_MUTABLE, ['notnull' => false]);
    }
}