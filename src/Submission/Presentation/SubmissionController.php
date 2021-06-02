<?php declare(strict_types=1);

namespace Socialnews\Submission\Presentation;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class SubmissionController
{
    public function show(Request $request) : Response
    {
        $content = 'Submission Controller';
        return new Response($content);
    }
}