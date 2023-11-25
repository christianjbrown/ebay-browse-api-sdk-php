<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Tests\Transformer;

use ChristianBrown\eBay\FindServiceApi\Model\Item;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemTransformer;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemTransformer::class)]
final class ItemTransformerTest extends TestCase
{
    public function test(): void
    {
        $data = [
            ItemTransformerInterface::DATA_KEY_ITEM_ID => [123],
        ];
        $transformer = new ItemTransformer();
        $actual = $transformer->transform($data);
        self::assertSame(123, $actual->getItemId());
    }
}
