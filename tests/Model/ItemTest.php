<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Tests\Model;

use ChristianBrown\eBay\FindServiceApi\Model\Item;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
final class ItemTest extends TestCase
{
    public function test(): void
    {
        $item = new Item();
        self::assertNull($item->getItemId());
        self::assertSame($item, $item->setItemId(1));
        self::assertSame(1, $item->getItemId());
    }
}
