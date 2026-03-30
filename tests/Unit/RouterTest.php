<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Exceptions\HttpException;
use App\Core\Middleware\MiddlewareInterface;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use PHPUnit\Framework\TestCase;

final class RouterTest extends TestCase
{
    public function testDispatchesRouteWithParameters(): void
    {
        $router = new Router();
        $router->get('/offres/{id}', static fn (Request $request): Response => Response::html('offre-' . $request->route('id')));

        $response = $router->dispatch(new Request('GET', '/offres/42'));

        self::assertSame(200, $this->responseStatus($response));
        self::assertSame('offre-42', $this->responseContent($response));
    }

    public function testRunsMiddlewareBeforeHandler(): void
    {
        $router = new Router();
        $router->get(
            '/secure',
            static fn (): Response => Response::html('handler'),
            [new class implements MiddlewareInterface
            {
                public function handle(Request $request, callable $next): Response
                {
                    $response = $next($request);

                    return Response::html('middleware+' . RouterTest::contentFromResponse($response), 201);
                }
            }]
        );

        $response = $router->dispatch(new Request('GET', '/secure'));

        self::assertSame(201, $this->responseStatus($response));
        self::assertSame('middleware+handler', $this->responseContent($response));
    }

    public function testThrowsNotFoundForUnknownRoute(): void
    {
        $router = new Router();

        $this->expectException(HttpException::class);
        $this->expectExceptionCode(404);

        $router->dispatch(new Request('GET', '/inconnue'));
    }

    public static function contentFromResponse(Response $response): string
    {
        $reflection = new \ReflectionClass($response);
        $property = $reflection->getProperty('content');

        return (string) $property->getValue($response);
    }

    private function responseContent(Response $response): string
    {
        return self::contentFromResponse($response);
    }

    private function responseStatus(Response $response): int
    {
        $reflection = new \ReflectionClass($response);
        $property = $reflection->getProperty('status');

        return (int) $property->getValue($response);
    }
}
