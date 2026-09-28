<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Cache;

/**
 * A single request-scoped cache keyed by an arbitrary string, shared by the
 * Api clients so each one can hold its own independent cache instance (or
 * instances, for a client with more than one cache key shape) behind the
 * same small contract.
 *
 * @template T
 */
interface KeyedCacheInterface
{
    /**
     * @return T
     */
    public function get(string $key): mixed;

    public function has(string $key): bool;

    /**
     * @param string $key   The cache key
     * @param T      $value
     */
    public function set(string $key, mixed $value): void;
}
