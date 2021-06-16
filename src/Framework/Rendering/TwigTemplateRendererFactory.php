<?php declare(strict_types=1);

namespace Socialnews\Framework\Rendering;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Session;
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
    private $session;

    public function __construct(
        TemplateDirectory $templateDirectory,
        StoredTokenReader $storedTokenReader,
        Session $session
    ) {
        $this->templateDirectory = $templateDirectory;
        $this->storedTokenReader = $storedTokenReader;
        $this->session = $session;
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
        $twigEnvironment->addFunction(
            new TwigFunction('get_flash_bag', function(): FlashBagInterface {
                return $this->session->getFlashBag();
            })
        );
        return new TwigTemplateRenderer($twigEnvironment);
    }
}