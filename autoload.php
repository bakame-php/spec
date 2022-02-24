<?php

declare(strict_types=1);

spl_autoload_register(function (string $className): void {
    if (!str_starts_with($className, 'Bakame\Specification\\')) {
        return;
    }

    $file = __DIR__.'/src/'.str_replace('\\', '/', substr($className, 20)).'.php';
    if (is_readable($file)) {
        require $file;
    }
});
