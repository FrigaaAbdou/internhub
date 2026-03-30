<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use App\Core\Auth;
use App\Core\Exceptions\HttpException;
use App\Core\Request;
use App\Core\Response;

final class EnsureRoleMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly array $roles,
    ) {
    }

    public function handle(Request $request, callable $next): Response
    {
        if (! Auth::check()) {
            return Response::redirect('/login');
        }

        if (! Auth::hasRole(...$this->roles)) {
            throw HttpException::forbidden();
        }

        return $next($request);
    }
}
