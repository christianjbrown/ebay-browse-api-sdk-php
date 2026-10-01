<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\TypedNameValueInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemDescriptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemDescriptionTransformer::class)]
final class ItemDescriptionTransformerTest extends TestCase
{
    public function testApply(): void
    {
        $typedNameValuesTransformerModel = self::createStub(TypedNameValueInterface::class);
        $typedNameValuesTransformer = self::createStub(TypedNameValuesTransformerInterface::class);
        $typedNameValuesTransformer->method('transform')->willReturn([$typedNameValuesTransformerModel]);
        $data = [
            ItemTransformerInterface::KEY_ADULT_ONLY => true,
            ItemTransformerInterface::KEY_AGE_GROUP => 'v_2',
            ItemTransformerInterface::KEY_BRAND => 'v_3',
            ItemTransformerInterface::KEY_CATEGORY_ID => 'v_4',
            ItemTransformerInterface::KEY_CATEGORY_ID_PATH => 'v_5',
            ItemTransformerInterface::KEY_CATEGORY_PATH => 'v_6',
            ItemTransformerInterface::KEY_COLOR => 'v_7',
            ItemTransformerInterface::KEY_DESCRIPTION => 'v_8',
            ItemTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS => 'v_9',
            ItemTransformerInterface::KEY_EPID => 'v_10',
            ItemTransformerInterface::KEY_GENDER => 'v_11',
            ItemTransformerInterface::KEY_GTIN => 'v_12',
            ItemTransformerInterface::KEY_INFERRED_EPID => 'v_13',
            ItemTransformerInterface::KEY_LEGACY_ITEM_ID => 'v_14',
            ItemTransformerInterface::KEY_LOCALIZED_ASPECTS => ['raw_LocalizedAspects'],
            ItemTransformerInterface::KEY_LOT_SIZE => 116,
            ItemTransformerInterface::KEY_MATERIAL => 'v_17',
            ItemTransformerInterface::KEY_MPN => 'v_18',
            ItemTransformerInterface::KEY_PATTERN => 'v_19',
            ItemTransformerInterface::KEY_REPAIR_SCORE => 'v_20',
            ItemTransformerInterface::KEY_SHORT_DESCRIPTION => 'v_21',
            ItemTransformerInterface::KEY_SIZE => 'v_22',
            ItemTransformerInterface::KEY_SIZE_SYSTEM => 'v_23',
            ItemTransformerInterface::KEY_SIZE_TYPE => 'v_24',
            ItemTransformerInterface::KEY_SUBTITLE => 'v_25',
            ItemTransformerInterface::KEY_TITLE => 'v_26',
        ];
        $item = new Item('v_0');

        $transformer = new ItemDescriptionTransformer($typedNameValuesTransformer);
        $transformer->apply($item, $data);

        self::assertTrue($item->getAdultOnly());
        self::assertSame('v_2', $item->getAgeGroup());
        self::assertSame('v_3', $item->getBrand());
        self::assertSame('v_4', $item->getCategoryId());
        self::assertSame('v_5', $item->getCategoryIdPath());
        self::assertSame('v_6', $item->getCategoryPath());
        self::assertSame('v_7', $item->getColor());
        self::assertSame('v_8', $item->getDescription());
        self::assertSame('v_9', $item->getEnergyEfficiencyClass());
        self::assertSame('v_10', $item->getEpid());
        self::assertSame('v_11', $item->getGender());
        self::assertSame('v_12', $item->getGtin());
        self::assertSame('v_13', $item->getInferredEpid());
        self::assertSame('v_14', $item->getLegacyItemId());
        self::assertSame([$typedNameValuesTransformerModel], $item->getLocalizedAspects());
        self::assertSame(116, $item->getLotSize());
        self::assertSame('v_17', $item->getMaterial());
        self::assertSame('v_18', $item->getMpn());
        self::assertSame('v_19', $item->getPattern());
        self::assertSame('v_20', $item->getRepairScore());
        self::assertSame('v_21', $item->getShortDescription());
        self::assertSame('v_22', $item->getSize());
        self::assertSame('v_23', $item->getSizeSystem());
        self::assertSame('v_24', $item->getSizeType());
        self::assertSame('v_25', $item->getSubtitle());
        self::assertSame('v_26', $item->getTitle());
    }

    public function testApplyLeavesTheItemUntouchedWhenNothingIsPresent(): void
    {
        $item = new Item('v_0');
        $transformer = new ItemDescriptionTransformer(self::createStub(TypedNameValuesTransformerInterface::class));

        $transformer->apply($item, []);

        self::assertSame(serialize(new Item('v_0')), serialize($item));
    }
}
