<?php

return [
    '~^articles/(\d+)$~' => [\Blog\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\Blog\Controllers\ArticlesController::class, 'edit'],
    '~^articles/add$~' => [\Blog\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)/delete$~' => [\Blog\Controllers\ArticlesController::class, 'delete'],
    '~^users/register$~' => [\Blog\Controllers\UsersController::class, 'singUp'],
    '~^users/login$~' => [\Blog\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\Blog\Controllers\UsersController::class, 'logout'],
    '~^users/(\d+)/activate/(.+)$~' => [\Blog\Controllers\UsersController::class, 'activate'],
    '~^$~' => [\Blog\Controllers\MainController::class, 'main'],
    '~^(\d+)$~' => [\Blog\Controllers\MainController::class, 'page'],
];
