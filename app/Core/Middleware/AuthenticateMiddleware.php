<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

final class AuthenticateMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        if (Auth::check()) {
            return $next($request);
        }

        if ($request->isMethod('GET')) {
            Session::put('auth.intended', $request->path());
        }

        Session::flash('error', 'Vous devez vous connecter pour acceder a cette page.');

        return Response::redirect('/login');
    }
}
