<?php declare(strict_types=1);

use Tracy\Debugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR.'/vendor/autoload.php';

Debugger::enable();

//throw new \Exception;

$request = Request::createFromGlobals();

$content = "Hello " . $request->get('name', 'visitor');

$response = new Response($content);
$response->prepare($request);
$response->send();
