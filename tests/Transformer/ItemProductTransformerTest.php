<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemGroupSummaryInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ProductInterface;
use ChristianBrown\EBay\Browse\Model\ReviewRatingInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupSummaryTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemProductTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ReviewRatingTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemProductTransformer::class)]
final class ItemProductTransformerTest extends TestCase
{
    private ?ItemGroupSummaryInterface $itemGroupSummary = null;
    private ?ProductInterface $product = null;
    private ?ReviewRatingInterface $reviewRating = null;

    public function testApply(): void
    {
        $data = [
            ItemTransformerInterface::KEY_PRIMARY_ITEM_GROUP => ['raw_primaryItemGroup'],
            ItemTransformerInterface::KEY_PRIMARY_PRODUCT_REVIEW_RATING => ['raw_primaryProductReviewRating'],
            ItemTransformerInterface::KEY_PRODUCT => ['raw_product'],
        ];

        $transformer = $this->buildTransformer();
        $actual = new Item('v_0');

        $transformer->apply($actual, $data);

        self::assertSame($this->itemGroupSummary, $actual->getPrimaryItemGroup());
        self::assertSame($this->reviewRating, $actual->getPrimaryProductReviewRating());
        self::assertSame($this->product, $actual->getProduct());
    }

    /**
     * @param array<string, mixed>         $data
     * @param Closure(ItemInterface): void $assert
     */
    #[DataProvider('provideApplyOptionalFieldStatesCases')]
    public function testApplyOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();
        $item = new Item('v_0');

        $transformer->apply($item, $data);

        $assert($item);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ItemInterface): void}>
     */
    public static function provideApplyOptionalFieldStatesCases(): iterable
    {
        $base = [ItemTransformerInterface::KEY_ITEM_ID => 'v_0'];

        yield 'allOptionalAbsent' => [
            [],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPrimaryItemGroup());
                self::assertNull($model->getPrimaryProductReviewRating());
                self::assertNull($model->getProduct());
            },
        ];

        yield 'primaryItemGroupWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRIMARY_ITEM_GROUP => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPrimaryItemGroup());
            },
        ];

        yield 'primaryProductReviewRatingWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRIMARY_PRODUCT_REVIEW_RATING => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPrimaryProductReviewRating());
            },
        ];

        yield 'productWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRODUCT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getProduct());
            },
        ];
    }

    private function buildTransformer(): ItemProductTransformer
    {
        $this->itemGroupSummary = self::createStub(ItemGroupSummaryInterface::class);
        $this->product = self::createStub(ProductInterface::class);
        $this->reviewRating = self::createStub(ReviewRatingInterface::class);

        $itemGroupSummaryTransformer = self::createStub(ItemGroupSummaryTransformerInterface::class);
        $itemGroupSummaryTransformer->method('transform')->willReturn($this->itemGroupSummary);
        $productTransformer = self::createStub(ProductTransformerInterface::class);
        $productTransformer->method('transform')->willReturn($this->product);
        $reviewRatingTransformer = self::createStub(ReviewRatingTransformerInterface::class);
        $reviewRatingTransformer->method('transform')->willReturn($this->reviewRating);

        return new ItemProductTransformer($itemGroupSummaryTransformer, $productTransformer, $reviewRatingTransformer);
    }
}
