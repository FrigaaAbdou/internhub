<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Exceptions\HttpException;
use App\Core\Middleware\MiddlewareInterface;

final class Router
{
    private array $routes = [];

    public function get(string $path, callable|array|string $handler, array $middleware = []): void
    {
        $this->match(['GET'], $path, $handler, $middleware);
    }

    public function post(string $path, callable|array|string $handler, array $middleware = []): void
    {
        $this->match(['POST'], $path, $handler, $middleware);
    }

    public function match(array $methods, string $path, callable|array|string $handler, array $middleware = []): void
    {
        $this->routes[] = [
            'methods' => array_map('strtoupper', $methods),
            'path' => Request::normalizePath($path),
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if (! in_array($request->method(), $route['methods'], true)) {
                continue;
            }

            $params = $this->matchPath($route['path'], $request->path());

            if ($params === null) {
                continue;
            }

            $request->setRouteParams($params);

            return $this->runRoute($request, $route['handler'], $route['middleware']);
        }

        throw HttpException::notFound();
    }

    private function runRoute(Request $request, callable|array|string $handler, array $middleware): Response
    {
        $pipeline = array_reduce(
            array_reverse($middleware),
            fn (callable $next, MiddlewareInterface|string|callable $current) => fn (Request $request): Response => $this->resolveMiddleware($current)->handle($request, $next),
            fn (Request $request): Response => Response::from($this->invokeHandler($handler, $request)),
        );

        return $pipeline($request);
    }

    private function resolveMiddleware(MiddlewareInterface|string|callable $middleware): MiddlewareInterface
    {
        if ($middleware instanceof MiddlewareInterface) {
            return $middleware;
        }

        if (is_string($middleware) && class_exists($middleware)) {
            $middleware = new $middleware();
        }

        throw new \RuntimeException('Middleware invalide fourni au routeur.');
    }

    private function invokeHandler(callable|array|string $handler, Request $request): mixed
    {
        if (is_callable($handler)) {
            return $handler($request);
        }

        if (is_array($handler) && count($handler) === 2) {
            [$class, $method] = $handler;
            $instance = is_string($class) ? new $class() : $class;

            return $instance->{$method}($request);
        }

        if (is_string($handler) && str_contains($handler, '@')) {
            [$class, $method] = explode('@', $handler, 2);

            return (new $class())->{$method}($request);
        }

        throw new \RuntimeException('Handler de route invalide.');
    }

    private function matchPath(string $routePath, string $requestPath): ?array
    {
        $pattern = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            static fn (array $matches): string => '(?P<' . $matches[1] . '>[^/]+)',
            $routePath,
        );

        if (! preg_match('#^' . $pattern . '$#', $requestPath, $matches)) {
            return null;
        }

        return array_filter(
            $matches,
            static fn (string|int $key): bool => ! is_int($key),
            ARRAY_FILTER_USE_KEY,
        );
    }
}
