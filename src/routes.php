<?php

return [
    '~^articles/(\d+)$~' => [\Blog\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\Blog\Controllers\ArticlesController::class, 'edit'],
    '~^articles/add$~' => [\Blog\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)/delete~' => [\Blog\Controllers\ArticlesController::class, 'delete'],
    '~users/register~' => [\Blog\Controllers\UsersController::class, 'singUp'],
    '~^$~' => [\Blog\Controllers\MainController::class, 'main'],
];
