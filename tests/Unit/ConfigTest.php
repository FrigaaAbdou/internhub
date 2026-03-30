<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Core\Config;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{
    protected function setUp(): void
    {
        Config::set('tests', []);
    }

    public function testCanStoreAndReadNestedConfigurationValues(): void
    {
        Config::set('tests.feature.enabled', true);
        Config::set('tests.feature.name', 'internhub');

        self::assertTrue(Config::get('tests.feature.enabled'));
        self::assertSame('internhub', Config::get('tests.feature.name'));
    }

    public function testReturnsDefaultForUnknownConfigurationPath(): void
    {
        self::assertSame('fallback', Config::get('tests.unknown.key', 'fallback'));
    }
}
