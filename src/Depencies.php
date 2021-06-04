<?php declare(strict_types=1);

use Auryn\Injector;
use Socialnews\Framework\Rendering\TemplateDirectory;
use Socialnews\Framework\Rendering\TemplateRenderer;
use Socialnews\Framework\Rendering\TwigTemplateRendererFactory;
use Socialnews\Frontpage\Application\SubmissionsQuery;
use Socialnews\Frontpage\Infrastructure\MockSubmissionsQuery;

$injector = new Injector();

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