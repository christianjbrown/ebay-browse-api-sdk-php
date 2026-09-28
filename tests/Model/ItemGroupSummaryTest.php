<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\ItemGroupSummary;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemGroupSummary::class)]
final class ItemGroupSummaryTest extends TestCase
{
    public function test(): void
    {
        $itemGroupAdditionalImages = [self::createStub(ImageInterface::class)];
        $itemGroupImage = self::createStub(ImageInterface::class);

        $itemGroupSummary = new ItemGroupSummary();
        self::assertSame([], $itemGroupSummary->getItemGroupAdditionalImages());
        self::assertNull($itemGroupSummary->getItemGroupHref());
        self::assertNull($itemGroupSummary->getItemGroupId());
        self::assertNull($itemGroupSummary->getItemGroupImage());
        self::assertNull($itemGroupSummary->getItemGroupTitle());
        self::assertNull($itemGroupSummary->getItemGroupType());

        self::assertSame($itemGroupSummary, $itemGroupSummary->setItemGroupAdditionalImages($itemGroupAdditionalImages));
        self::assertSame($itemGroupSummary, $itemGroupSummary->setItemGroupHref('val_itemGroupHref'));
        self::assertSame($itemGroupSummary, $itemGroupSummary->setItemGroupId('val_itemGroupId'));
        self::assertSame($itemGroupSummary, $itemGroupSummary->setItemGroupImage($itemGroupImage));
        self::assertSame($itemGroupSummary, $itemGroupSummary->setItemGroupTitle('val_itemGroupTitle'));
        self::assertSame($itemGroupSummary, $itemGroupSummary->setItemGroupType('val_itemGroupType'));

        self::assertSame($itemGroupAdditionalImages, $itemGroupSummary->getItemGroupAdditionalImages());
        self::assertSame('val_itemGroupHref', $itemGroupSummary->getItemGroupHref());
        self::assertSame('val_itemGroupId', $itemGroupSummary->getItemGroupId());
        self::assertSame($itemGroupImage, $itemGroupSummary->getItemGroupImage());
        self::assertSame('val_itemGroupTitle', $itemGroupSummary->getItemGroupTitle());
        self::assertSame('val_itemGroupType', $itemGroupSummary->getItemGroupType());
    }
}
