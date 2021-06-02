<?php declare(strict_types=1);

namespace Socialnews\Frontpage\Presentation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class FrontPageController
{
    public function show(Request $request) : Response
    {
        $content = "hello ".$request->get('name')." from frontpage";
        return new Response($content);
    }
}