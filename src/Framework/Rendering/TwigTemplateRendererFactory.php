<?php declare(strict_types=1);

namespace Socialnews\Framework\Rendering;

use Twig\Loader\FilesystemLoader;
// use Twig_Loader_Filesystem
use Twig\Environment;
// use Twig_Environment

final class TwigTemplateRendererFactory
{
    private $templateDirectory;

    public function __construct(TemplateDirectory $templateDirectory)
    {
        $this->templateDirectory = $templateDirectory;
    }

    public function create(): TwigTemplateRenderer
    {
        $templateDirectory = $this->templateDirectory->toString();
        $loader = new FilesystemLoader([$templateDirectory]);
        $twigEnvironment = new Environment($loader);
        return new TwigTemplateRenderer($twigEnvironment);
    }
}