<?php

return [
    '~^hello/(.*)$~' => [\Blog\Controllers\MainController::class, 'sayHello'],
    '~^$~' => [\Blog\Controllers\MainController::class, 'main'],
];