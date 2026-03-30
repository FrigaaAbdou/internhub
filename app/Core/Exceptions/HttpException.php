<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use RuntimeException;

final class HttpException extends RuntimeException
{
    public function __construct(
        private readonly int $statusCode,
        string $message = '',
    ) {
        parent::__construct($message ?: self::defaultMessage($statusCode), $statusCode);
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public static function forbidden(string $message = 'Acces refuse.'): self
    {
        return new self(403, $message);
    }

    public static function notFound(string $message = 'Ressource introuvable.'): self
    {
        return new self(404, $message);
    }

    public static function serverError(string $message = 'Une erreur technique est survenue.'): self
    {
        return new self(500, $message);
    }

    private static function defaultMessage(int $statusCode): string
    {
        return match ($statusCode) {
            403 => 'Acces refuse.',
            404 => 'Ressource introuvable.',
            default => 'Une erreur technique est survenue.',
        };
    }
}
