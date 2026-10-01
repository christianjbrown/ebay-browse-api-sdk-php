<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ConditionDescriptorInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemConditionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemConditionTransformer::class)]
final class ItemConditionTransformerTest extends TestCase
{
    public function testApply(): void
    {
        $conditionDescriptorsTransformerModel = self::createStub(ConditionDescriptorInterface::class);
        $conditionDescriptorsTransformer = self::createStub(ConditionDescriptorsTransformerInterface::class);
        $conditionDescriptorsTransformer->method('transform')->willReturn([$conditionDescriptorsTransformerModel]);
        $data = [
            ItemTransformerInterface::KEY_CONDITION => 'v_1',
            ItemTransformerInterface::KEY_CONDITION_DESCRIPTION => 'v_2',
            ItemTransformerInterface::KEY_CONDITION_DESCRIPTORS => ['raw_ConditionDescriptors'],
            ItemTransformerInterface::KEY_CONDITION_ID => 'v_4',
        ];
        $item = new Item('v_0');

        $transformer = new ItemConditionTransformer($conditionDescriptorsTransformer);
        $transformer->apply($item, $data);

        self::assertSame('v_1', $item->getCondition());
        self::assertSame('v_2', $item->getConditionDescription());
        self::assertSame([$conditionDescriptorsTransformerModel], $item->getConditionDescriptors());
        self::assertSame('v_4', $item->getConditionId());
    }

    public function testApplyLeavesTheItemUntouchedWhenNothingIsPresent(): void
    {
        $item = new Item('v_0');
        $transformer = new ItemConditionTransformer(self::createStub(ConditionDescriptorsTransformerInterface::class));

        $transformer->apply($item, []);

        self::assertSame(serialize(new Item('v_0')), serialize($item));
    }
}
