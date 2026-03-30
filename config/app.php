<?php

declare(strict_types=1);

$basePath = dirname(__DIR__);

return [
    'name' => env('APP_NAME', 'InternHub'),
    'env' => env('APP_ENV', 'local'),
    'debug' => filter_var(env('APP_DEBUG', 'false'), FILTER_VALIDATE_BOOL),
    'url' => rtrim((string) env('APP_URL', ''), '/'),
    'timezone' => env('APP_TIMEZONE', 'Europe/Paris'),
    'meta' => [
        'default_description' => env('APP_META_DESCRIPTION', 'InternHub centralise les offres de stage, les candidatures, le suivi pedagogique et la gestion des comptes dans une application MVC PHP.'),
    ],
    'legal' => [
        'publisher' => env('LEGAL_PUBLISHER', 'Projet pedagogique InternHub'),
        'director' => env('LEGAL_DIRECTOR', 'Equipe projet InternHub'),
        'contact_email' => env('LEGAL_CONTACT_EMAIL', 'contact@internhub.test'),
        'hosting' => env('LEGAL_HOSTING', 'Hebergement local ou environnement de demonstration'),
    ],
    'paths' => [
        'base' => $basePath,
        'views' => $basePath . '/app/Views',
        'storage' => $basePath . '/storage',
        'logs' => $basePath . '/storage/logs',
    ],
    'session' => [
        'name' => env('SESSION_NAME', 'internhub_session'),
        'lifetime' => (int) env('SESSION_LIFETIME', '7200'),
        'path' => $basePath . '/storage/sessions',
        'secure' => filter_var(env('SESSION_SECURE', 'false'), FILTER_VALIDATE_BOOL),
        'httponly' => true,
        'samesite' => env('SESSION_SAMESITE', 'Lax'),
    ],
];
