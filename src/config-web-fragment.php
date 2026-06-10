<?php

declare(strict_types=1);

return [
    'controllerNamespace' => 'app\Infrastructure\Http\Controller',
    'viewPath' => '@app/example-full/Infrastructure/Http/View',
    'container' => require __DIR__ . '/config-di.php',
];

