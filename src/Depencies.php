<?php declare(strict_types=1);

use Auryn\Injector;
use Socialnews\Framework\Rendering\TemplateDirectory;
use Socialnews\Framework\Rendering\TemplateRenderer;
use Socialnews\Framework\Rendering\TwigTemplateRendererFactory;
use Socialnews\Frontpage\Application\SubmissionsQuery;
use Socialnews\Frontpage\Infrastructure\MockSubmissionsQuery;
use Doctrine\DBAL\Connection;
use Socialnews\Framework\DBal\ConnectionFactory;
use Socialnews\Framework\Dbal\DatabaseUrl;

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

$injector->alias(SubmissionsQuery::class, MockSubmissionsQuery::class);
$injector->share(SubmissionsQuery::class);

$injector->define(TemplateDirectory::class, [':rootDirectory' => ROOT_DIR]);

$injector->delegate(
    TemplateRenderer::class,
    function () use ($injector): TemplateRenderer {
        $factory = $injector->make(TwigTemplateRendererFactory::class);
        return $factory->create();
    }
);

return $injector;