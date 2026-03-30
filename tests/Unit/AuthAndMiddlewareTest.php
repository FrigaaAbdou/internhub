<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Auth;
use App\Core\Middleware\AuthenticateMiddleware;
use App\Core\Middleware\EnsureRoleMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use PHPUnit\Framework\TestCase;

final class AuthAndMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        $_SESSION = [];
    }

    public function testAuthReadsCurrentUserFromSession(): void
    {
        $_SESSION['auth']['user'] = [
            'id' => '7',
            'role' => 'etudiant',
            'email' => 'student@internhub.test',
        ];

        self::assertTrue(Auth::check());
        self::assertSame(7, Auth::id());
        self::assertSame('etudiant', Auth::role());
        self::assertTrue(Auth::hasRole('etudiant', 'pilote'));
        self::assertFalse(Auth::hasRole('administrateur'));
    }

    public function testAuthenticateMiddlewareRedirectsGuestAndStoresIntendedPathForGet(): void
    {
        $middleware = new AuthenticateMiddleware();
        $response = $middleware->handle(
            new Request('GET', '/dashboard/etudiant'),
            static fn (): Response => Response::html('ok')
        );

        self::assertSame('/login', $this->responseHeader($response, 'Location'));
        self::assertSame('/dashboard/etudiant', Session::get('auth.intended'));
        self::assertSame('Vous devez vous connecter pour acceder a cette page.', Session::pullFlash('error'));
    }

    public function testEnsureRoleMiddlewareAllowsExpectedRole(): void
    {
        $_SESSION['auth']['user'] = [
            'id' => 3,
            'role' => 'pilote',
        ];

        $middleware = new EnsureRoleMiddleware(['pilote']);
        $response = $middleware->handle(
            new Request('GET', '/dashboard/pilote'),
            static fn (): Response => Response::html('allowed', 200)
        );

        self::assertSame(200, $this->responseStatus($response));
        self::assertSame('allowed', $this->responseContent($response));
    }

    public function testEnsureRoleMiddlewareRedirectsGuestToLogin(): void
    {
        $middleware = new EnsureRoleMiddleware(['administrateur']);
        $response = $middleware->handle(
            new Request('GET', '/admin/comptes'),
            static fn (): Response => Response::html('forbidden')
        );

        self::assertSame('/login', $this->responseHeader($response, 'Location'));
    }

    public function testEnsureRoleMiddlewareRejectsWrongRole(): void
    {
        $_SESSION['auth']['user'] = [
            'id' => 3,
            'role' => 'etudiant',
        ];

        $middleware = new EnsureRoleMiddleware(['administrateur']);

        $this->expectException(\App\Core\Exceptions\HttpException::class);
        $this->expectExceptionCode(403);

        $middleware->handle(
            new Request('GET', '/admin/comptes'),
            static fn (): Response => Response::html('nope')
        );
    }

    private function responseContent(Response $response): string
    {
        $reflection = new \ReflectionClass($response);
        $property = $reflection->getProperty('content');

        return (string) $property->getValue($response);
    }

    private function responseStatus(Response $response): int
    {
        $reflection = new \ReflectionClass($response);
        $property = $reflection->getProperty('status');

        return (int) $property->getValue($response);
    }

    private function responseHeader(Response $response, string $header): ?string
    {
        $reflection = new \ReflectionClass($response);
        $property = $reflection->getProperty('headers');
        $headers = (array) $property->getValue($response);

        return $headers[$header] ?? null;
    }
}
