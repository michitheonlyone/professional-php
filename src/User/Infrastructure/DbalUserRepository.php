<?php declare(strict_types=1);

namespace Socialnews\User\Infrastructure;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Types\Types;
use Ramsey\Uuid\Uuid;
use Socialnews\User\Domain\User;
use Socialnews\User\Domain\UserRepository;
use Socialnews\User\Domain\UserWasLoggedIn;
use Symfony\Component\HttpFoundation\Session\Session;


final class DbalUserRepository implements UserRepository
{
    private $connection;
    private $session;

    public function __construct(
        Connection $connection,
        Session $session
    ) {
        $this->connection = $connection;
        $this->session = $session;
    }

    public function add(User $user): void
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->insert('users');
        $qb->values([
            'id' => $qb->createNamedParameter($user->getId()->toString()),
            'nickname' => $qb->createNamedParameter($user->getNickname()),
            'password_hash' => $qb->createNamedParameter($user->getPasswordHash()),
            'creation_date' => $qb->createNamedParameter($user->getCreationDate(), Types::DATETIME_MUTABLE)
        ]);
        $qb->executeQuery();
    }

    public function save(User $user): void
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->update('users');
        $qb->set('nickname',$qb->createNamedParameter($user->getNickname()));
        $qb->set('password_hash', $qb->createNamedParameter($user->getPasswordHash()));
        $qb->set('failed_login_attempts', $qb->createNamedParameter($user->getFailedLoginAttempts()));
        $qb->set('last_failed_login_attempt', $qb->createNamedParameter($user->getLastFailedLoginAttempt(), Types::DATETIME_MUTABLE));
        $qb->executeQuery();

        foreach ($user->getRecordedEvents() as $event) {
            if ($event instanceof UserWasLoggedIn) {
                $this->session->set('userId', $user->getId()->toString());
                continue;
            }
            throw new \LogicException(get_class($event) . " was not handled");
        }
        $user->clearRecordedEvents();
    }

    public function findByNickName(string $nickname): ?User
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->addSelect('id');
        $qb->addSelect('nickname');
        $qb->addSelect('password_hash');
        $qb->addSelect('creation_date');
        $qb->addSelect('failed_login_attempts');
        $qb->addSelect('last_failed_login_attempt');
        $qb->from('users');
        $qb->where('nickname ='.$qb->createNamedParameter($nickname));
        $stm = $qb->executeQuery();
        $row = $stm->fetchAssociative();

        if (!$row) {
            return null;
        }

        return $this->createUserFromRow($row);
    }

    public function createUserFromRow(array $row): ?User
    {
        if (!$row) {
            return null;
        }

        $lastFailedLoginAttempt = null;
        if ($row['last_failed_login_attempt']) {
            $lastFailedLoginAttempt = new DateTimeImmutable($row['last_failed_login_attempt']);
        }

        return new User(
            Uuid::fromString($row['id']),
            $row['nickname'],
            $row['password_hash'],
            new DateTimeImmutable($row['creation_date']),
            (int)$row['failed_login_attempts'],
            $lastFailedLoginAttempt
        );
    }
}