<?php

return [
    '~^articles/(\d+)$~' => [\Blog\Controllers\ArticlesController::class, 'view'],
    '~^$~' => [\Blog\Controllers\MainController::class, 'main'],
];
