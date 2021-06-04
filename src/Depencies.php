<?php declare(strict_types=1);

use Auryn\Injector;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Socialnews\Framework\Rendering\TemplateDirectory;
use Socialnews\Framework\Rendering\TemplateRenderer;
use Socialnews\Framework\Rendering\TwigTemplateRendererFactory;
use Socialnews\Framework\DBal\ConnectionFactory;
use Socialnews\Framework\Dbal\DatabaseUrl;
use Socialnews\Framework\Csrf\TokenStorage;
use Socialnews\Framework\Csrf\SymfonySessionTokenStorage;
use Socialnews\Frontpage\Infrastructure\DbalSubmissionsQuery;
use Socialnews\Frontpage\Application\SubmissionsQuery;

$injector = new Injector();

$injector->define(
    DatabaseUrl::class,
    [':url' => 'sqlite:///'.ROOT_DIR.'/storage/db.sqlite3']
);
$injector->delegate(Connection::class, function() use ($injector):Connection {
    $factory = $injector->make(ConnectionFactory::class);
    return $factory->create();
});
$injector->share(Connection::class);

$injector->alias(SubmissionsQuery::class, DbalSubmissionsQuery::class);
$injector->share(SubmissionsQuery::class);

$injector->alias(TokenStorage::class, SymfonySessionTokenStorage::class);
$injector->alias(SessionInterface::class, Session::class);
$injector->define(TemplateDirectory::class, [':rootDirectory' => ROOT_DIR]);
$injector->delegate(
    TemplateRenderer::class,
    function () use ($injector): TemplateRenderer {
        $factory = $injector->make(TwigTemplateRendererFactory::class);
        return $factory->create();
    }
);

return $injector;