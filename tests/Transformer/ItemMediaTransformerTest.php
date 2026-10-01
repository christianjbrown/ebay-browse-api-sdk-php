<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemMediaTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemMediaTransformer::class)]
final class ItemMediaTransformerTest extends TestCase
{
    public function testApply(): void
    {
        $imagesTransformerModel = self::createStub(ImageInterface::class);
        $imagesTransformer = self::createStub(ImagesTransformerInterface::class);
        $imagesTransformer->method('transform')->willReturn([$imagesTransformerModel]);
        $imageTransformerModel = self::createStub(ImageInterface::class);
        $imageTransformer = self::createStub(ImageTransformerInterface::class);
        $imageTransformer->method('transform')->willReturn($imageTransformerModel);
        $data = [
            ItemTransformerInterface::KEY_ADDITIONAL_IMAGES => ['raw_AdditionalImages'],
            ItemTransformerInterface::KEY_IMAGE => ['raw_Image'],
            ItemTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL => 'v_3',
            ItemTransformerInterface::KEY_ITEM_WEB_URL => 'v_4',
            ItemTransformerInterface::KEY_PRODUCT_FICHE_WEB_URL => 'v_5',
            ItemTransformerInterface::KEY_TYRE_LABEL_IMAGE_URL => 'v_6',
        ];
        $item = new Item('v_0');

        $transformer = new ItemMediaTransformer($imageTransformer, $imagesTransformer);
        $transformer->apply($item, $data);

        self::assertSame([$imagesTransformerModel], $item->getAdditionalImages());
        self::assertSame($imageTransformerModel, $item->getImage());
        self::assertSame('v_3', $item->getItemAffiliateWebUrl());
        self::assertSame('v_4', $item->getItemWebUrl());
        self::assertSame('v_5', $item->getProductFicheWebUrl());
        self::assertSame('v_6', $item->getTyreLabelImageUrl());
    }

    public function testApplyLeavesTheItemUntouchedWhenNothingIsPresent(): void
    {
        $item = new Item('v_0');
        $transformer = new ItemMediaTransformer(self::createStub(ImageTransformerInterface::class), self::createStub(ImagesTransformerInterface::class));

        $transformer->apply($item, []);

        self::assertSame(serialize(new Item('v_0')), serialize($item));
    }
}
