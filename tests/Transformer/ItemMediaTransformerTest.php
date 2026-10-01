<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemMediaTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemMediaTransformer::class)]
final class ItemMediaTransformerTest extends TestCase
{
    private ?ImageInterface $image = null;

    public function testApply(): void
    {
        $data = [
            ItemTransformerInterface::KEY_ADDITIONAL_IMAGES => ['raw_additionalImages'],
            ItemTransformerInterface::KEY_IMAGE => ['raw_image'],
            ItemTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL => 'v_17',
            ItemTransformerInterface::KEY_ITEM_WEB_URL => 'v_18',
            ItemTransformerInterface::KEY_PRODUCT_FICHE_WEB_URL => 'v_26',
            ItemTransformerInterface::KEY_TYRE_LABEL_IMAGE_URL => 'v_36',
        ];

        $transformer = $this->buildTransformer();
        $actual = new Item('v_0');

        $transformer->apply($actual, $data);

        self::assertSame([$this->image], $actual->getAdditionalImages());
        self::assertSame($this->image, $actual->getImage());
        self::assertSame('v_17', $actual->getItemAffiliateWebUrl());
        self::assertSame('v_18', $actual->getItemWebUrl());
        self::assertSame('v_26', $actual->getProductFicheWebUrl());
        self::assertSame('v_36', $actual->getTyreLabelImageUrl());
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
                self::assertSame([], $model->getAdditionalImages());
                self::assertNull($model->getImage());
                self::assertNull($model->getItemAffiliateWebUrl());
                self::assertNull($model->getItemWebUrl());
                self::assertNull($model->getProductFicheWebUrl());
                self::assertNull($model->getTyreLabelImageUrl());
            },
        ];

        yield 'additionalImagesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ADDITIONAL_IMAGES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getAdditionalImages());
            },
        ];

        yield 'imageWrongType' => [
            [...$base, ItemTransformerInterface::KEY_IMAGE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getImage());
            },
        ];

        yield 'itemAffiliateWebUrlWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemAffiliateWebUrl());
            },
        ];

        yield 'itemWebUrlWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_WEB_URL => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemWebUrl());
            },
        ];

        yield 'productFicheWebUrlWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRODUCT_FICHE_WEB_URL => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getProductFicheWebUrl());
            },
        ];

        yield 'tyreLabelImageUrlWrongType' => [
            [...$base, ItemTransformerInterface::KEY_TYRE_LABEL_IMAGE_URL => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getTyreLabelImageUrl());
            },
        ];
    }

    private function buildTransformer(): ItemMediaTransformer
    {
        $this->image = self::createStub(ImageInterface::class);

        $imageTransformer = self::createStub(ImageTransformerInterface::class);
        $imageTransformer->method('transform')->willReturn($this->image);
        $imagesTransformer = self::createStub(ImagesTransformerInterface::class);
        $imagesTransformer->method('transform')->willReturn([$this->image]);

        return new ItemMediaTransformer($imageTransformer, $imagesTransformer);
    }
}
