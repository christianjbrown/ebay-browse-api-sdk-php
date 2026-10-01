<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\TypedNameValueInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemDescriptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
#[CoversClass(ItemDescriptionTransformer::class)]
final class ItemDescriptionTransformerTest extends TestCase
{
    private ?TypedNameValueInterface $typedNameValue = null;

    public function testApply(): void
    {
        $data = [
            ItemTransformerInterface::KEY_ADULT_ONLY => true,
            ItemTransformerInterface::KEY_AGE_GROUP => 'v_1',
            ItemTransformerInterface::KEY_BRAND => 'v_3',
            ItemTransformerInterface::KEY_CATEGORY_ID => 'v_4',
            ItemTransformerInterface::KEY_CATEGORY_ID_PATH => 'v_5',
            ItemTransformerInterface::KEY_CATEGORY_PATH => 'v_6',
            ItemTransformerInterface::KEY_COLOR => 'v_7',
            ItemTransformerInterface::KEY_DESCRIPTION => 'v_11',
            ItemTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS => 'v_12',
            ItemTransformerInterface::KEY_EPID => 'v_13',
            ItemTransformerInterface::KEY_GENDER => 'v_14',
            ItemTransformerInterface::KEY_GTIN => 'v_15',
            ItemTransformerInterface::KEY_INFERRED_EPID => 'v_16',
            ItemTransformerInterface::KEY_LEGACY_ITEM_ID => 'v_19',
            ItemTransformerInterface::KEY_LOCALIZED_ASPECTS => ['raw_localizedAspects'],
            ItemTransformerInterface::KEY_LOT_SIZE => 121,
            ItemTransformerInterface::KEY_MATERIAL => 'v_22',
            ItemTransformerInterface::KEY_MPN => 'v_23',
            ItemTransformerInterface::KEY_PATTERN => 'v_24',
            ItemTransformerInterface::KEY_REPAIR_SCORE => 'v_28',
            ItemTransformerInterface::KEY_SHORT_DESCRIPTION => 'v_30',
            ItemTransformerInterface::KEY_SIZE => 'v_31',
            ItemTransformerInterface::KEY_SIZE_SYSTEM => 'v_32',
            ItemTransformerInterface::KEY_SIZE_TYPE => 'v_33',
            ItemTransformerInterface::KEY_SUBTITLE => 'v_34',
            ItemTransformerInterface::KEY_TITLE => 'v_35',
        ];

        $transformer = $this->buildTransformer();
        $actual = new Item('v_0');

        $transformer->apply($actual, $data);

        self::assertTrue($actual->getAdultOnly());
        self::assertSame('v_1', $actual->getAgeGroup());
        self::assertSame('v_3', $actual->getBrand());
        self::assertSame('v_4', $actual->getCategoryId());
        self::assertSame('v_5', $actual->getCategoryIdPath());
        self::assertSame('v_6', $actual->getCategoryPath());
        self::assertSame('v_7', $actual->getColor());
        self::assertSame('v_11', $actual->getDescription());
        self::assertSame('v_12', $actual->getEnergyEfficiencyClass());
        self::assertSame('v_13', $actual->getEpid());
        self::assertSame('v_14', $actual->getGender());
        self::assertSame('v_15', $actual->getGtin());
        self::assertSame('v_16', $actual->getInferredEpid());
        self::assertSame('v_19', $actual->getLegacyItemId());
        self::assertSame([$this->typedNameValue], $actual->getLocalizedAspects());
        self::assertSame(121, $actual->getLotSize());
        self::assertSame('v_22', $actual->getMaterial());
        self::assertSame('v_23', $actual->getMpn());
        self::assertSame('v_24', $actual->getPattern());
        self::assertSame('v_28', $actual->getRepairScore());
        self::assertSame('v_30', $actual->getShortDescription());
        self::assertSame('v_31', $actual->getSize());
        self::assertSame('v_32', $actual->getSizeSystem());
        self::assertSame('v_33', $actual->getSizeType());
        self::assertSame('v_34', $actual->getSubtitle());
        self::assertSame('v_35', $actual->getTitle());
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
                self::assertNull($model->getAdultOnly());
                self::assertNull($model->getAgeGroup());
                self::assertNull($model->getBrand());
                self::assertNull($model->getCategoryId());
                self::assertNull($model->getCategoryIdPath());
                self::assertNull($model->getCategoryPath());
                self::assertNull($model->getColor());
                self::assertNull($model->getDescription());
                self::assertNull($model->getEnergyEfficiencyClass());
                self::assertNull($model->getEpid());
                self::assertNull($model->getGender());
                self::assertNull($model->getGtin());
                self::assertNull($model->getInferredEpid());
                self::assertNull($model->getLegacyItemId());
                self::assertSame([], $model->getLocalizedAspects());
                self::assertNull($model->getLotSize());
                self::assertNull($model->getMaterial());
                self::assertNull($model->getMpn());
                self::assertNull($model->getPattern());
                self::assertNull($model->getRepairScore());
                self::assertNull($model->getShortDescription());
                self::assertNull($model->getSize());
                self::assertNull($model->getSizeSystem());
                self::assertNull($model->getSizeType());
                self::assertNull($model->getSubtitle());
                self::assertNull($model->getTitle());
            },
        ];

        yield 'adultOnlyWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ADULT_ONLY => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getAdultOnly());
            },
        ];

        yield 'adultOnlyFalse' => [
            [...$base, ItemTransformerInterface::KEY_ADULT_ONLY => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getAdultOnly());
            },
        ];

        yield 'ageGroupWrongType' => [
            [...$base, ItemTransformerInterface::KEY_AGE_GROUP => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getAgeGroup());
            },
        ];

        yield 'brandWrongType' => [
            [...$base, ItemTransformerInterface::KEY_BRAND => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getBrand());
            },
        ];

        yield 'categoryIdWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CATEGORY_ID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCategoryId());
            },
        ];

        yield 'categoryIdPathWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CATEGORY_ID_PATH => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCategoryIdPath());
            },
        ];

        yield 'categoryPathWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CATEGORY_PATH => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCategoryPath());
            },
        ];

        yield 'colorWrongType' => [
            [...$base, ItemTransformerInterface::KEY_COLOR => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getColor());
            },
        ];

        yield 'descriptionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_DESCRIPTION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getDescription());
            },
        ];

        yield 'energyEfficiencyClassWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getEnergyEfficiencyClass());
            },
        ];

        yield 'epidWrongType' => [
            [...$base, ItemTransformerInterface::KEY_EPID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getEpid());
            },
        ];

        yield 'genderWrongType' => [
            [...$base, ItemTransformerInterface::KEY_GENDER => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getGender());
            },
        ];

        yield 'gtinWrongType' => [
            [...$base, ItemTransformerInterface::KEY_GTIN => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getGtin());
            },
        ];

        yield 'inferredEpidWrongType' => [
            [...$base, ItemTransformerInterface::KEY_INFERRED_EPID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getInferredEpid());
            },
        ];

        yield 'legacyItemIdWrongType' => [
            [...$base, ItemTransformerInterface::KEY_LEGACY_ITEM_ID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getLegacyItemId());
            },
        ];

        yield 'localizedAspectsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_LOCALIZED_ASPECTS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getLocalizedAspects());
            },
        ];

        yield 'lotSizeWrongType' => [
            [...$base, ItemTransformerInterface::KEY_LOT_SIZE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getLotSize());
            },
        ];

        yield 'lotSizeZero' => [
            [...$base, ItemTransformerInterface::KEY_LOT_SIZE => 0],
            static function (ItemInterface $model): void {
                self::assertSame(0, $model->getLotSize());
            },
        ];

        yield 'materialWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MATERIAL => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getMaterial());
            },
        ];

        yield 'mpnWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MPN => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getMpn());
            },
        ];

        yield 'patternWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PATTERN => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPattern());
            },
        ];

        yield 'repairScoreWrongType' => [
            [...$base, ItemTransformerInterface::KEY_REPAIR_SCORE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getRepairScore());
            },
        ];

        yield 'shortDescriptionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SHORT_DESCRIPTION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getShortDescription());
            },
        ];

        yield 'sizeWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SIZE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSize());
            },
        ];

        yield 'sizeSystemWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SIZE_SYSTEM => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSizeSystem());
            },
        ];

        yield 'sizeTypeWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SIZE_TYPE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSizeType());
            },
        ];

        yield 'subtitleWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SUBTITLE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSubtitle());
            },
        ];

        yield 'titleWrongType' => [
            [...$base, ItemTransformerInterface::KEY_TITLE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getTitle());
            },
        ];
    }

    private function buildTransformer(): ItemDescriptionTransformer
    {
        $this->typedNameValue = self::createStub(TypedNameValueInterface::class);

        $typedNameValuesTransformer = self::createStub(TypedNameValuesTransformerInterface::class);
        $typedNameValuesTransformer->method('transform')->willReturn([$this->typedNameValue]);

        return new ItemDescriptionTransformer($typedNameValuesTransformer);
    }
}
