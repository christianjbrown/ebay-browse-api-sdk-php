<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ItemsResponse;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemsResponse::class)]
final class ItemsResponseTest extends TestCase
{
    public function test(): void
    {
        $items = [self::createStub(ItemInterface::class)];
        $warnings = [self::createStub(ErrorInterface::class)];

        $itemsResponse = new ItemsResponse();
        self::assertSame([], $itemsResponse->getItems());
        self::assertNull($itemsResponse->getTotal());
        self::assertSame([], $itemsResponse->getWarnings());

        self::assertSame($itemsResponse, $itemsResponse->setItems($items));
        self::assertSame($itemsResponse, $itemsResponse->setTotal(42));
        self::assertSame($itemsResponse, $itemsResponse->setWarnings($warnings));

        self::assertSame($items, $itemsResponse->getItems());
        self::assertSame(42, $itemsResponse->getTotal());
        self::assertSame($warnings, $itemsResponse->getWarnings());
    }
}
