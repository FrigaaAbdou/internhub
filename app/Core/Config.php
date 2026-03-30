<?php

declare(strict_types=1);

namespace App\Core;

final class Config
{
    private static array $items = [];

    public static function set(string $key, mixed $value): void
    {
        data_set(self::$items, $key, $value);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return data_get(self::$items, $key, $default);
    }

    public static function all(): array
    {
        return self::$items;
    }
}

function data_get(array $target, string $key, mixed $default = null): mixed
{
    $segments = explode('.', $key);

    foreach ($segments as $segment) {
        if (! is_array($target) || ! array_key_exists($segment, $target)) {
            return $default;
        }

        $target = $target[$segment];
    }

    return $target;
}

function data_set(array &$target, string $key, mixed $value): void
{
    $segments = explode('.', $key);
    $current = &$target;

    foreach ($segments as $segment) {
        if (! isset($current[$segment]) || ! is_array($current[$segment])) {
            $current[$segment] = [];
        }

        $current = &$current[$segment];
    }

    $current = $value;
}
