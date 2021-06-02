<?php declare(strict_types=1);

use Tracy\Debugger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

define('ROOT_DIR', dirname(__DIR__));

require ROOT_DIR.'/vendor/autoload.php';

Debugger::enable();

//throw new \Exception;

$request = Request::createFromGlobals();

$dispatcher = \FastRoute\simpleDispatcher(
    function (\FastRoute\RouteCollector $r) {
        $routes = include(ROOT_DIR.'/src/Routes.php');
        foreach ($routes as $route) {
            $r->addRoute(...$route);
        }
    });

$routeInfo = $dispatcher->dispatch(
    $request->getMethod(),
    $request->getPathInfo()
);

switch ($routeInfo[0]) {
    case \FastRoute\Dispatcher::NOT_FOUND:
        $response = new Response('Not Found', 404);
        break;
    case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $response = new Response('Method not Allowed', 405);
        break;
    case \FastRoute\Dispatcher::FOUND:
        [$controllerName, $method] = explode('#', $routeInfo[1]);
        $vars = $routeInfo[2];

        $controller = new $controllerName;
        $response = $controller->$method($request, $vars);
        break;
}

//if(!$response instanceof Response) throw new Exception('Controller Method must return a Responsee object');

$response->prepare($request);
$response->send();
