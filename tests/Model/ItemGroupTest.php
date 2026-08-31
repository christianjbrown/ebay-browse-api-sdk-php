<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\CommonDescriptionInterface;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\ItemGroup;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemGroup::class)]
final class ItemGroupTest extends TestCase
{
    public function test(): void
    {
        $commonDescriptions = [self::createStub(CommonDescriptionInterface::class)];
        $items = [self::createStub(ItemInterface::class)];
        $warnings = [self::createStub(ErrorInterface::class)];

        $itemGroup = new ItemGroup();
        self::assertSame([], $itemGroup->getCommonDescriptions());
        self::assertSame([], $itemGroup->getItems());
        self::assertSame([], $itemGroup->getWarnings());

        self::assertSame($itemGroup, $itemGroup->setCommonDescriptions($commonDescriptions));
        self::assertSame($itemGroup, $itemGroup->setItems($items));
        self::assertSame($itemGroup, $itemGroup->setWarnings($warnings));

        self::assertSame($commonDescriptions, $itemGroup->getCommonDescriptions());
        self::assertSame($items, $itemGroup->getItems());
        self::assertSame($warnings, $itemGroup->getWarnings());
    }
}
