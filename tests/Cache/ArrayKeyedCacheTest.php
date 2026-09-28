<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Cache;

use ChristianBrown\EBay\Browse\Cache\ArrayKeyedCache;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ArrayKeyedCache::class)]
final class ArrayKeyedCacheTest extends TestCase
{
    public function testHasReturnsFalseForAMissingKey(): void
    {
        $cache = new ArrayKeyedCache();

        self::assertFalse($cache->has('missing'));
    }

    public function testSetOverwritesAnExistingKey(): void
    {
        $cache = new ArrayKeyedCache();

        $cache->set('key', 'first');
        $cache->set('key', 'second');

        self::assertSame('second', $cache->get('key'));
    }

    public function testSetThenGetReturnsTheStoredValue(): void
    {
        $cache = new ArrayKeyedCache();

        $cache->set('key', 'value');

        self::assertTrue($cache->has('key'));
        self::assertSame('value', $cache->get('key'));
    }
}
