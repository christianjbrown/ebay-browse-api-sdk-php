<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Cache;

/**
 * @template T
 *
 * @implements KeyedCacheInterface<T>
 */
final class ArrayKeyedCache implements KeyedCacheInterface
{
    /**
     * @var array<string, T>
     */
    private array $items = [];

    public function get(string $key): mixed
    {
        return $this->items[$key];
    }

    public function has(string $key): bool
    {
        return isset($this->items[$key]);
    }

    public function set(string $key, mixed $value): void
    {
        $this->items[$key] = $value;
    }
}
