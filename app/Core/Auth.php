<?php

declare(strict_types=1);

namespace App\Core;

final class Auth
{
    public static function check(): bool
    {
        return is_array(Session::get('auth.user'));
    }

    public static function user(): ?array
    {
        $user = Session::get('auth.user');

        return is_array($user) ? $user : null;
    }

    public static function login(array $user): void
    {
        Session::regenerate();
        Session::put('auth.user', $user);
    }

    public static function logout(): void
    {
        Session::forget('auth');
        Session::regenerate();
    }

    public static function id(): ?int
    {
        $id = self::user()['id'] ?? null;

        return is_int($id) ? $id : (is_numeric($id) ? (int) $id : null);
    }

    public static function role(): ?string
    {
        $role = self::user()['role'] ?? null;

        return is_string($role) ? $role : null;
    }

    public static function hasRole(string ...$roles): bool
    {
        $currentRole = self::role();

        return is_string($currentRole) && in_array($currentRole, $roles, true);
    }
}
