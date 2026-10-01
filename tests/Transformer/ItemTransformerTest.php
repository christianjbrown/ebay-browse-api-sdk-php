<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Transformer\ItemComplianceTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemConditionTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemDescriptionTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemFulfilmentTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemListingTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemMediaTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemPricingTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemProductTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Item::class)]
#[CoversClass(ItemTransformer::class)]
final class ItemTransformerTest extends TestCase
{
    public function testTransformAppliesEveryPartToTheItem(): void
    {
        $data = [ItemTransformerInterface::KEY_ITEM_ID => 'v_0', 'extra' => 'x'];
        $descriptionTransformer = self::createMock(ItemDescriptionTransformerInterface::class);
        $descriptionTransformer->expects(self::once())->method('apply')->with(self::isInstanceOf(Item::class), $data);
        $conditionTransformer = self::createMock(ItemConditionTransformerInterface::class);
        $conditionTransformer->expects(self::once())->method('apply')->with(self::isInstanceOf(Item::class), $data);
        $mediaTransformer = self::createMock(ItemMediaTransformerInterface::class);
        $mediaTransformer->expects(self::once())->method('apply')->with(self::isInstanceOf(Item::class), $data);
        $pricingTransformer = self::createMock(ItemPricingTransformerInterface::class);
        $pricingTransformer->expects(self::once())->method('apply')->with(self::isInstanceOf(Item::class), $data);
        $fulfilmentTransformer = self::createMock(ItemFulfilmentTransformerInterface::class);
        $fulfilmentTransformer->expects(self::once())->method('apply')->with(self::isInstanceOf(Item::class), $data);
        $listingTransformer = self::createMock(ItemListingTransformerInterface::class);
        $listingTransformer->expects(self::once())->method('apply')->with(self::isInstanceOf(Item::class), $data);
        $productTransformer = self::createMock(ItemProductTransformerInterface::class);
        $productTransformer->expects(self::once())->method('apply')->with(self::isInstanceOf(Item::class), $data);
        $complianceTransformer = self::createMock(ItemComplianceTransformerInterface::class);
        $complianceTransformer->expects(self::once())->method('apply')->with(self::isInstanceOf(Item::class), $data);

        $transformer = new ItemTransformer($descriptionTransformer, $conditionTransformer, $mediaTransformer, $pricingTransformer, $fulfilmentTransformer, $listingTransformer, $productTransformer, $complianceTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getItemId());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ItemTransformerInterface::KEY_ITEM_ID => 42]])]
    public function testTransformThrowsOnInvalidItemId(array $data): void
    {
        $transformer = new ItemTransformer(self::createStub(ItemDescriptionTransformerInterface::class), self::createStub(ItemConditionTransformerInterface::class), self::createStub(ItemMediaTransformerInterface::class), self::createStub(ItemPricingTransformerInterface::class), self::createStub(ItemFulfilmentTransformerInterface::class), self::createStub(ItemListingTransformerInterface::class), self::createStub(ItemProductTransformerInterface::class), self::createStub(ItemComplianceTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, ItemTransformerInterface::KEY_ITEM_ID));

        $transformer->transform($data);
    }
}
