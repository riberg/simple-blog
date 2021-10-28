<?php

return [
    '~^articles/(\d+)$~' => [\Blog\Controllers\Api\ArticlesApiController::class, 'view'],
    '~^articles/add$~' => [\Blog\Controllers\Api\ArticlesApiController::class, 'add'],
];