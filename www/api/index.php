<?php

require __DIR__ . '/../../vendor/autoload.php';

try {
    $route = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/../../src/routes_api.php';

    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \Blog\Exceptions\NotFoundException('Route not found');
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName;
    $controller->$actionName(...$matches);
} catch (\Blog\Exceptions\DbException $e) {
    $view = new Blog\View\View(__DIR__ . '/../templates/errors');
    $view->displayJson(['error' => $e->getMessage()], 500);
} catch (\Blog\Exceptions\NotFoundException $e) {
    $view = new \Blog\View\View(__DIR__ . '/../templates/errors');
    $view->displayJson(['error' => $e->getMessage()], 404);
} catch (\Blog\Exceptions\UnauthorizedException $e) {
    $view = new Blog\View\View(__DIR__ . '/../templates/errors');
    $view->displayJson(['error' => $e->getMessage()], 401);
}
