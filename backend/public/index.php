<?php

require_once dirname(__DIR__, 1) . '/config/bootstrap.php';

use App\Http\Request;
use FastRoute\RouteCollector;

// Rotas
$dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $router) {
    require dirname(__DIR__, 1) . '/config/api.php';
});

$method = $_SERVER['REQUEST_METHOD'];
$uri = strtok($_SERVER['REQUEST_URI'], '?');

$routeInfo = $dispatcher->dispatch($method, $uri);

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

switch ($routeInfo[0]) {

    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;

    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;

     case FastRoute\Dispatcher::FOUND:
        [$class, $method] = $routeInfo[1];
        $vars = $routeInfo[2];

        $controller = $container->get($class);

        $request = new Request();

        echo call_user_func_array([$controller, $method], [$request, ...array_values($vars)]);
        break;
}