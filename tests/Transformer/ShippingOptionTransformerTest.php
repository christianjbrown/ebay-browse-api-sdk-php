<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\ShippingOption;
use ChristianBrown\EBay\Browse\Model\ShippingOptionInterface;
use ChristianBrown\EBay\Browse\Model\ShipToLocationInterface;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShippingOption::class)]
#[CoversClass(ShippingOptionTransformer::class)]
final class ShippingOptionTransformerTest extends TestCase
{
    private ?ConvertedAmountInterface $convertedAmount = null;
    private ?ShipToLocationInterface $shipToLocation = null;

    public function testTransform(): void
    {
        $data = [
            ShippingOptionTransformerInterface::KEY_ADDITIONAL_SHIPPING_COST_PER_UNIT => ['raw_additionalShippingCostPerUnit'],
            ShippingOptionTransformerInterface::KEY_CUT_OFF_DATE_USED_FOR_ESTIMATE => '2024-01-02T03:04:05.000Z',
            ShippingOptionTransformerInterface::KEY_FULFILLED_THROUGH => 'v_1',
            ShippingOptionTransformerInterface::KEY_GUARANTEED_DELIVERY => true,
            ShippingOptionTransformerInterface::KEY_IMPORT_CHARGES => ['raw_importCharges'],
            ShippingOptionTransformerInterface::KEY_MAX_ESTIMATED_DELIVERY_DATE => '2024-01-02T03:04:05.000Z',
            ShippingOptionTransformerInterface::KEY_MIN_ESTIMATED_DELIVERY_DATE => '2024-01-02T03:04:05.000Z',
            ShippingOptionTransformerInterface::KEY_QUANTITY_USED_FOR_ESTIMATE => 102,
            ShippingOptionTransformerInterface::KEY_SHIPPING_CARRIER_CODE => 'v_3',
            ShippingOptionTransformerInterface::KEY_SHIPPING_COST => ['raw_shippingCost'],
            ShippingOptionTransformerInterface::KEY_SHIPPING_COST_TYPE => 'v_4',
            ShippingOptionTransformerInterface::KEY_SHIPPING_SERVICE_CODE => 'v_5',
            ShippingOptionTransformerInterface::KEY_SHIP_TO_LOCATION_USED_FOR_ESTIMATE => ['raw_shipToLocationUsedForEstimate'],
            ShippingOptionTransformerInterface::KEY_TRADEMARK_SYMBOL => 'v_6',
            ShippingOptionTransformerInterface::KEY_TYPE => 'v_7',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($this->convertedAmount, $actual->getAdditionalShippingCostPerUnit());
        self::assertSame(1704164645, $actual->getCutOffDateUsedForEstimate());
        self::assertSame('v_1', $actual->getFulfilledThrough());
        self::assertTrue($actual->getGuaranteedDelivery());
        self::assertSame($this->convertedAmount, $actual->getImportCharges());
        self::assertSame(1704164645, $actual->getMaxEstimatedDeliveryDate());
        self::assertSame(1704164645, $actual->getMinEstimatedDeliveryDate());
        self::assertSame(102, $actual->getQuantityUsedForEstimate());
        self::assertSame('v_3', $actual->getShippingCarrierCode());
        self::assertSame($this->convertedAmount, $actual->getShippingCost());
        self::assertSame('v_4', $actual->getShippingCostType());
        self::assertSame('v_5', $actual->getShippingServiceCode());
        self::assertSame($this->shipToLocation, $actual->getShipToLocationUsedForEstimate());
        self::assertSame('v_6', $actual->getTrademarkSymbol());
        self::assertSame('v_7', $actual->getType());
    }

    /**
     * @param array<string, mixed>                   $data
     * @param Closure(ShippingOptionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ShippingOptionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getAdditionalShippingCostPerUnit());
                self::assertNull($model->getCutOffDateUsedForEstimate());
                self::assertNull($model->getFulfilledThrough());
                self::assertNull($model->getGuaranteedDelivery());
                self::assertNull($model->getImportCharges());
                self::assertNull($model->getMaxEstimatedDeliveryDate());
                self::assertNull($model->getMinEstimatedDeliveryDate());
                self::assertNull($model->getQuantityUsedForEstimate());
                self::assertNull($model->getShippingCarrierCode());
                self::assertNull($model->getShippingCost());
                self::assertNull($model->getShippingCostType());
                self::assertNull($model->getShippingServiceCode());
                self::assertNull($model->getShipToLocationUsedForEstimate());
                self::assertNull($model->getTrademarkSymbol());
                self::assertNull($model->getType());
            },
        ];

        yield 'additionalShippingCostPerUnitWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_ADDITIONAL_SHIPPING_COST_PER_UNIT => 'x'],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getAdditionalShippingCostPerUnit());
            },
        ];

        yield 'cutOffDateUsedForEstimateWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_CUT_OFF_DATE_USED_FOR_ESTIMATE => 42],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getCutOffDateUsedForEstimate());
            },
        ];

        yield 'cutOffDateUsedForEstimateUnparseable' => [
            [...$base, ShippingOptionTransformerInterface::KEY_CUT_OFF_DATE_USED_FOR_ESTIMATE => 'not-a-date'],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getCutOffDateUsedForEstimate());
            },
        ];

        yield 'fulfilledThroughWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_FULFILLED_THROUGH => 42],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getFulfilledThrough());
            },
        ];

        yield 'guaranteedDeliveryWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_GUARANTEED_DELIVERY => 'x'],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getGuaranteedDelivery());
            },
        ];

        yield 'guaranteedDeliveryFalse' => [
            [...$base, ShippingOptionTransformerInterface::KEY_GUARANTEED_DELIVERY => false],
            static function (ShippingOptionInterface $model): void {
                self::assertFalse($model->getGuaranteedDelivery());
            },
        ];

        yield 'importChargesWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_IMPORT_CHARGES => 'x'],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getImportCharges());
            },
        ];

        yield 'maxEstimatedDeliveryDateWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_MAX_ESTIMATED_DELIVERY_DATE => 42],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getMaxEstimatedDeliveryDate());
            },
        ];

        yield 'maxEstimatedDeliveryDateUnparseable' => [
            [...$base, ShippingOptionTransformerInterface::KEY_MAX_ESTIMATED_DELIVERY_DATE => 'not-a-date'],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getMaxEstimatedDeliveryDate());
            },
        ];

        yield 'minEstimatedDeliveryDateWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_MIN_ESTIMATED_DELIVERY_DATE => 42],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getMinEstimatedDeliveryDate());
            },
        ];

        yield 'minEstimatedDeliveryDateUnparseable' => [
            [...$base, ShippingOptionTransformerInterface::KEY_MIN_ESTIMATED_DELIVERY_DATE => 'not-a-date'],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getMinEstimatedDeliveryDate());
            },
        ];

        yield 'quantityUsedForEstimateWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_QUANTITY_USED_FOR_ESTIMATE => 'x'],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getQuantityUsedForEstimate());
            },
        ];

        yield 'quantityUsedForEstimateZero' => [
            [...$base, ShippingOptionTransformerInterface::KEY_QUANTITY_USED_FOR_ESTIMATE => 0],
            static function (ShippingOptionInterface $model): void {
                self::assertSame(0, $model->getQuantityUsedForEstimate());
            },
        ];

        yield 'shippingCarrierCodeWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_SHIPPING_CARRIER_CODE => 42],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getShippingCarrierCode());
            },
        ];

        yield 'shippingCostWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_SHIPPING_COST => 'x'],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getShippingCost());
            },
        ];

        yield 'shippingCostTypeWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_SHIPPING_COST_TYPE => 42],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getShippingCostType());
            },
        ];

        yield 'shippingServiceCodeWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_SHIPPING_SERVICE_CODE => 42],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getShippingServiceCode());
            },
        ];

        yield 'shipToLocationUsedForEstimateWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_SHIP_TO_LOCATION_USED_FOR_ESTIMATE => 'x'],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getShipToLocationUsedForEstimate());
            },
        ];

        yield 'trademarkSymbolWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_TRADEMARK_SYMBOL => 42],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getTrademarkSymbol());
            },
        ];

        yield 'typeWrongType' => [
            [...$base, ShippingOptionTransformerInterface::KEY_TYPE => 42],
            static function (ShippingOptionInterface $model): void {
                self::assertNull($model->getType());
            },
        ];
    }

    private function buildTransformer(): ShippingOptionTransformer
    {
        $this->convertedAmount = self::createStub(ConvertedAmountInterface::class);
        $this->shipToLocation = self::createStub(ShipToLocationInterface::class);

        $convertedAmountTransformer = self::createStub(ConvertedAmountTransformerInterface::class);
        $convertedAmountTransformer->method('transform')->willReturn($this->convertedAmount);
        $shipToLocationTransformer = self::createStub(ShipToLocationTransformerInterface::class);
        $shipToLocationTransformer->method('transform')->willReturn($this->shipToLocation);

        return new ShippingOptionTransformer($convertedAmountTransformer, $shipToLocationTransformer);
    }
}
