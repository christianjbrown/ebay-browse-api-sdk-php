<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\ItemGroupSummary;
use ChristianBrown\EBay\Browse\Model\ItemGroupSummaryInterface;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupSummaryTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ItemGroupSummary::class)]
#[CoversClass(ItemGroupSummaryTransformer::class)]
final class ItemGroupSummaryTransformerTest extends TestCase
{
    private ?ImageInterface $image = null;

    public function testTransform(): void
    {
        $data = [
            ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_ADDITIONAL_IMAGES => ['raw_itemGroupAdditionalImages'],
            ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_HREF => 'v_1',
            ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_ID => 'v_2',
            ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_IMAGE => ['raw_itemGroupImage'],
            ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_TITLE => 'v_3',
            ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_TYPE => 'v_4',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->image], $actual->getItemGroupAdditionalImages());
        self::assertSame('v_1', $actual->getItemGroupHref());
        self::assertSame('v_2', $actual->getItemGroupId());
        self::assertSame($this->image, $actual->getItemGroupImage());
        self::assertSame('v_3', $actual->getItemGroupTitle());
        self::assertSame('v_4', $actual->getItemGroupType());
    }

    /**
     * @param array<string, mixed>                     $data
     * @param Closure(ItemGroupSummaryInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ItemGroupSummaryInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ItemGroupSummaryInterface $model): void {
                self::assertSame([], $model->getItemGroupAdditionalImages());
                self::assertNull($model->getItemGroupHref());
                self::assertNull($model->getItemGroupId());
                self::assertNull($model->getItemGroupImage());
                self::assertNull($model->getItemGroupTitle());
                self::assertNull($model->getItemGroupType());
            },
        ];

        yield 'itemGroupAdditionalImagesWrongType' => [
            [...$base, ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_ADDITIONAL_IMAGES => 'x'],
            static function (ItemGroupSummaryInterface $model): void {
                self::assertSame([], $model->getItemGroupAdditionalImages());
            },
        ];

        yield 'itemGroupHrefWrongType' => [
            [...$base, ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_HREF => 42],
            static function (ItemGroupSummaryInterface $model): void {
                self::assertNull($model->getItemGroupHref());
            },
        ];

        yield 'itemGroupIdWrongType' => [
            [...$base, ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_ID => 42],
            static function (ItemGroupSummaryInterface $model): void {
                self::assertNull($model->getItemGroupId());
            },
        ];

        yield 'itemGroupImageWrongType' => [
            [...$base, ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_IMAGE => 'x'],
            static function (ItemGroupSummaryInterface $model): void {
                self::assertNull($model->getItemGroupImage());
            },
        ];

        yield 'itemGroupTitleWrongType' => [
            [...$base, ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_TITLE => 42],
            static function (ItemGroupSummaryInterface $model): void {
                self::assertNull($model->getItemGroupTitle());
            },
        ];

        yield 'itemGroupTypeWrongType' => [
            [...$base, ItemGroupSummaryTransformerInterface::KEY_ITEM_GROUP_TYPE => 42],
            static function (ItemGroupSummaryInterface $model): void {
                self::assertNull($model->getItemGroupType());
            },
        ];
    }

    private function buildTransformer(): ItemGroupSummaryTransformer
    {
        $this->image = self::createStub(ImageInterface::class);

        $imageTransformer = self::createStub(ImageTransformerInterface::class);
        $imageTransformer->method('transform')->willReturn($this->image);
        $imagesTransformer = self::createStub(ImagesTransformerInterface::class);
        $imagesTransformer->method('transform')->willReturn([$this->image]);

        return new ItemGroupSummaryTransformer($imageTransformer, $imagesTransformer);
    }
}
