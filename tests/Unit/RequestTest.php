<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Request;
use PHPUnit\Framework\TestCase;

final class RequestTest extends TestCase
{
    public function testNormalizePathCollapsesTrailingSlashes(): void
    {
        self::assertSame('/', Request::normalizePath('/'));
        self::assertSame('/dashboard/etudiant', Request::normalizePath('/dashboard/etudiant/'));
        self::assertSame('/offres/42', Request::normalizePath('offres/42///'));
    }

    public function testRequestExposesQueryInputAndRouteParameters(): void
    {
        $request = new Request(
            'POST',
            '/offres/42',
            ['page' => '2'],
            ['title' => 'Stage Data'],
            [],
            ['HTTP_X_TEST' => 'yes'],
            ['session' => 'abc'],
        );
        $request->setRouteParams(['id' => '42']);

        self::assertTrue($request->isMethod('post'));
        self::assertSame('2', $request->query('page'));
        self::assertSame('Stage Data', $request->input('title'));
        self::assertSame('42', $request->route('id'));
        self::assertSame('yes', $request->header('X-Test'));
        self::assertSame('abc', $request->cookie('session'));
    }
}
