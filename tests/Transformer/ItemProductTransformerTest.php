<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemGroupSummaryInterface;
use ChristianBrown\EBay\Browse\Model\ProductInterface;
use ChristianBrown\EBay\Browse\Model\ReviewRatingInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupSummaryTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemProductTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ReviewRatingTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemProductTransformer::class)]
final class ItemProductTransformerTest extends TestCase
{
    public function testApply(): void
    {
        $itemGroupSummaryTransformerModel = self::createStub(ItemGroupSummaryInterface::class);
        $itemGroupSummaryTransformer = self::createStub(ItemGroupSummaryTransformerInterface::class);
        $itemGroupSummaryTransformer->method('transform')->willReturn($itemGroupSummaryTransformerModel);
        $reviewRatingTransformerModel = self::createStub(ReviewRatingInterface::class);
        $reviewRatingTransformer = self::createStub(ReviewRatingTransformerInterface::class);
        $reviewRatingTransformer->method('transform')->willReturn($reviewRatingTransformerModel);
        $productTransformerModel = self::createStub(ProductInterface::class);
        $productTransformer = self::createStub(ProductTransformerInterface::class);
        $productTransformer->method('transform')->willReturn($productTransformerModel);
        $data = [
            ItemTransformerInterface::KEY_PRIMARY_ITEM_GROUP => ['raw_PrimaryItemGroup'],
            ItemTransformerInterface::KEY_PRIMARY_PRODUCT_REVIEW_RATING => ['raw_PrimaryProductReviewRating'],
            ItemTransformerInterface::KEY_PRODUCT => ['raw_Product'],
        ];
        $item = new Item('v_0');

        $transformer = new ItemProductTransformer($itemGroupSummaryTransformer, $productTransformer, $reviewRatingTransformer);
        $transformer->apply($item, $data);

        self::assertSame($itemGroupSummaryTransformerModel, $item->getPrimaryItemGroup());
        self::assertSame($reviewRatingTransformerModel, $item->getPrimaryProductReviewRating());
        self::assertSame($productTransformerModel, $item->getProduct());
    }

    public function testApplyLeavesTheItemUntouchedWhenNothingIsPresent(): void
    {
        $item = new Item('v_0');
        $transformer = new ItemProductTransformer(self::createStub(ItemGroupSummaryTransformerInterface::class), self::createStub(ProductTransformerInterface::class), self::createStub(ReviewRatingTransformerInterface::class));

        $transformer->apply($item, []);

        self::assertSame(serialize(new Item('v_0')), serialize($item));
    }
}
