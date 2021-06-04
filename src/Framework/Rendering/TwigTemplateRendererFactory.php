<?php declare(strict_types=1);

namespace Socialnews\Framework\Rendering;

use Twig\Loader\FilesystemLoader;
// use Twig_Loader_Filesystem
use Twig\Environment;
// use Twig_Environment
use Socialnews\Framework\Csrf\StoredTokenReader;
use Twig\TwigFunction;

final class TwigTemplateRendererFactory
{
    private $templateDirectory;
    private $storedTokenReader;

    public function __construct(TemplateDirectory $templateDirectory, StoredTokenReader $storedTokenReader)
    {
        $this->templateDirectory = $templateDirectory;
        $this->storedTokenReader = $storedTokenReader;
    }

    public function create(): TwigTemplateRenderer
    {
        $templateDirectory = $this->templateDirectory->toString();
        $loader = new FilesystemLoader([$templateDirectory]);
        $twigEnvironment = new Environment($loader);
        $twigEnvironment->addFunction(
            new TwigFunction('get_token', function (string $key): string {
                $token = $this->storedTokenReader->read($key);
                return $token->toString();
            })
        );
        return new TwigTemplateRenderer($twigEnvironment);
    }
}