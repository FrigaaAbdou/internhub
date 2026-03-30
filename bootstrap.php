<?php

declare(strict_types=1);

require_once __DIR__ . '/app/Core/helpers.php';

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';

    if (! str_starts_with($class, $prefix)) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = __DIR__ . '/app/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require_once $file;
    }
});

\App\Core\Env::load(__DIR__ . '/.env');

date_default_timezone_set((string) env('APP_TIMEZONE', 'Europe/Paris'));

return new \App\Core\App(__DIR__);
