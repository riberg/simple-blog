<?php

try {
    require __DIR__ . '/../vendor/autoload.php';

    $route = $_GET['route'] ?? '';
    $routes = require __DIR__ . '/../src/routes.php';

    $isRouteFound = false;
    foreach ($routes as $pattern => $controllerAndAction) {
        preg_match($pattern, $route, $matches);
        if (!empty($matches)) {
            $isRouteFound = true;
            break;
        }
    }

    if (!$isRouteFound) {
        throw new \Blog\Exceptions\NotFoundException();
    }

    unset($matches[0]);

    $controllerName = $controllerAndAction[0];
    $actionName = $controllerAndAction[1];

    $controller = new $controllerName();
    $controller->$actionName(...$matches);
} catch (\Blog\Exceptions\DbException $e) {
    $view = new \Blog\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('500.php', ['error' => $e->getMessage()], 500);
} catch (\Blog\Exceptions\NotFoundException $e) {
    $view = new \Blog\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('404.php', ['error' => $e->getMessage()], 404);
} catch (\Blog\Exceptions\UnauthorizedException $e) {
    $view = new \Blog\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('401.php', ['error' => $e->getMessage()], 401);
} catch (\Blog\Exceptions\ForbiddenException $e) {
    $view = new \Blog\View\View(__DIR__ . '/../templates/errors');
    $view->renderHtml('403.php', ['error' => $e->getMessage()], 403);
}
