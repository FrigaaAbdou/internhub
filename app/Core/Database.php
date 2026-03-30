<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

final class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $config = (array) Config::get('database', []);
        $options = $config['options'] ?? [];
        $dsn = (string) ($config['dsn'] ?? '');

        if ($dsn === '') {
            $driver = (string) ($config['driver'] ?? 'mysql');

            $dsn = sprintf(
                '%s:host=%s;port=%d;dbname=%s;charset=%s',
                $driver,
                $config['host'] ?? '127.0.0.1',
                (int) ($config['port'] ?? 3306),
                $config['database'] ?? 'internhub',
                $config['charset'] ?? 'utf8mb4',
            );
        }

        self::$connection = new PDO(
            $dsn,
            (string) ($config['username'] ?? ''),
            (string) ($config['password'] ?? ''),
            $options,
        );

        return self::$connection;
    }
}
