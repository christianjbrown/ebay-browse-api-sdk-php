<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ConditionDescriptorInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemConditionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemConditionTransformer::class)]
final class ItemConditionTransformerTest extends TestCase
{
    private ?ConditionDescriptorInterface $conditionDescriptor = null;

    public function testApply(): void
    {
        $data = [
            ItemTransformerInterface::KEY_CONDITION => 'v_8',
            ItemTransformerInterface::KEY_CONDITION_DESCRIPTION => 'v_9',
            ItemTransformerInterface::KEY_CONDITION_DESCRIPTORS => ['raw_conditionDescriptors'],
            ItemTransformerInterface::KEY_CONDITION_ID => 'v_10',
        ];

        $transformer = $this->buildTransformer();
        $actual = new Item('v_0');

        $transformer->apply($actual, $data);

        self::assertSame('v_8', $actual->getCondition());
        self::assertSame('v_9', $actual->getConditionDescription());
        self::assertSame([$this->conditionDescriptor], $actual->getConditionDescriptors());
        self::assertSame('v_10', $actual->getConditionId());
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
                self::assertNull($model->getCondition());
                self::assertNull($model->getConditionDescription());
                self::assertSame([], $model->getConditionDescriptors());
                self::assertNull($model->getConditionId());
            },
        ];

        yield 'conditionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CONDITION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCondition());
            },
        ];

        yield 'conditionDescriptionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CONDITION_DESCRIPTION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getConditionDescription());
            },
        ];

        yield 'conditionDescriptorsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CONDITION_DESCRIPTORS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getConditionDescriptors());
            },
        ];

        yield 'conditionIdWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CONDITION_ID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getConditionId());
            },
        ];
    }

    private function buildTransformer(): ItemConditionTransformer
    {
        $this->conditionDescriptor = self::createStub(ConditionDescriptorInterface::class);

        $conditionDescriptorsTransformer = self::createStub(ConditionDescriptorsTransformerInterface::class);
        $conditionDescriptorsTransformer->method('transform')->willReturn([$this->conditionDescriptor]);

        return new ItemConditionTransformer($conditionDescriptorsTransformer);
    }
}
