<?php

declare(strict_types=1);

spl_autoload_register(function (string $className): void {

    static $length = 20; //strlen('Bakame\Specification\\')
    if (!str_starts_with($className, 'Bakame\Specification\\')) {
        return;
    }

    $file = __DIR__.'/src/'.str_replace('\\', '/', substr($className, $length)).'.php';
    if (is_readable($file)) {
        require $file;
    }
});
