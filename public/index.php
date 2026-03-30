<?php

declare(strict_types=1);

if (PHP_SAPI === 'cli-server') {
    $requestedPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $publicPath = __DIR__ . $requestedPath;

    if ($requestedPath !== '/' && is_file($publicPath)) {
        return false;
    }
}

$app = require dirname(__DIR__) . '/bootstrap.php';
$app->run();
