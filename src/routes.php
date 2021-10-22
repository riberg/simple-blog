<?php

return [
    '~^hello/(.*)$~' => [\Blog\Controllers\MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [\Blog\Controllers\MainController::class, 'sayBye'],
    '~^$~' => [\Blog\Controllers\MainController::class, 'main'],
];