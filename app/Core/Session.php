<?php

declare(strict_types=1);

namespace App\Core;

final class Session
{
    private static array $config = [];

    public static function configure(array $config): void
    {
        self::$config = $config;
    }

    public static function start(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        $path = self::$config['path'] ?? sys_get_temp_dir();

        if (! is_dir($path)) {
            mkdir($path, 0775, true);
        }

        session_name((string) (self::$config['name'] ?? 'internhub_session'));
        session_save_path((string) $path);
        session_set_cookie_params([
            'lifetime' => (int) (self::$config['lifetime'] ?? 7200),
            'path' => '/',
            'secure' => (bool) (self::$config['secure'] ?? false),
            'httponly' => (bool) (self::$config['httponly'] ?? true),
            'samesite' => (string) (self::$config['samesite'] ?? 'Lax'),
        ]);

        session_start();
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $segments = explode('.', $key);
        $value = $_SESSION ?? [];

        foreach ($segments as $segment) {
            if (! is_array($value) || ! array_key_exists($segment, $value)) {
                return $default;
            }

            $value = $value[$segment];
        }

        return $value;
    }

    public static function put(string $key, mixed $value): void
    {
        $segments = explode('.', $key);
        $current = &$_SESSION;

        foreach ($segments as $segment) {
            if (! isset($current[$segment]) || ! is_array($current[$segment])) {
                $current[$segment] = [];
            }

            $current = &$current[$segment];
        }

        $current = $value;
    }

    public static function flash(string $key, mixed $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function pull(string $key, mixed $default = null): mixed
    {
        $value = self::get($key, $default);
        self::forget($key);

        return $value;
    }

    public static function pullFlash(string $key, mixed $default = null): mixed
    {
        $value = $_SESSION['_flash'][$key] ?? $default;
        unset($_SESSION['_flash'][$key]);

        return $value;
    }

    public static function forget(string $key): void
    {
        $segments = explode('.', $key);
        $current = &$_SESSION;

        while (count($segments) > 1) {
            $segment = array_shift($segments);

            if (! isset($current[$segment]) || ! is_array($current[$segment])) {
                return;
            }

            $current = &$current[$segment];
        }

        unset($current[array_shift($segments)]);
    }

    public static function regenerate(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
}
