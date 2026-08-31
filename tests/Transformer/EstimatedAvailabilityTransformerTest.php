<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\EstimatedAvailability;
use ChristianBrown\EBay\Browse\Model\EstimatedAvailabilityInterface;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilityTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilityTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EstimatedAvailability::class)]
#[CoversClass(EstimatedAvailabilityTransformer::class)]
final class EstimatedAvailabilityTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EstimatedAvailabilityTransformerInterface::KEY_AVAILABILITY_THRESHOLD => 100,
            EstimatedAvailabilityTransformerInterface::KEY_AVAILABILITY_THRESHOLD_TYPE => 'v_1',
            EstimatedAvailabilityTransformerInterface::KEY_DELIVERY_OPTIONS => ['raw_deliveryOptions'],
            EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_AVAILABILITY_STATUS => 'v_3',
            EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_AVAILABLE_QUANTITY => 104,
            EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_REMAINING_QUANTITY => 105,
            EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_SOLD_QUANTITY => 106,
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(100, $actual->getAvailabilityThreshold());
        self::assertSame('v_1', $actual->getAvailabilityThresholdType());
        self::assertSame(['s'], $actual->getDeliveryOptions());
        self::assertSame('v_3', $actual->getEstimatedAvailabilityStatus());
        self::assertSame(104, $actual->getEstimatedAvailableQuantity());
        self::assertSame(105, $actual->getEstimatedRemainingQuantity());
        self::assertSame(106, $actual->getEstimatedSoldQuantity());
    }

    /**
     * @param array<string, mixed>                          $data
     * @param Closure(EstimatedAvailabilityInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(EstimatedAvailabilityInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertNull($model->getAvailabilityThreshold());
                self::assertNull($model->getAvailabilityThresholdType());
                self::assertSame([], $model->getDeliveryOptions());
                self::assertNull($model->getEstimatedAvailabilityStatus());
                self::assertNull($model->getEstimatedAvailableQuantity());
                self::assertNull($model->getEstimatedRemainingQuantity());
                self::assertNull($model->getEstimatedSoldQuantity());
            },
        ];

        yield 'availabilityThresholdWrongType' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_AVAILABILITY_THRESHOLD => 'x'],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertNull($model->getAvailabilityThreshold());
            },
        ];

        yield 'availabilityThresholdZero' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_AVAILABILITY_THRESHOLD => 0],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertSame(0, $model->getAvailabilityThreshold());
            },
        ];

        yield 'availabilityThresholdTypeWrongType' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_AVAILABILITY_THRESHOLD_TYPE => 42],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertNull($model->getAvailabilityThresholdType());
            },
        ];

        yield 'deliveryOptionsWrongType' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_DELIVERY_OPTIONS => 'x'],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertSame([], $model->getDeliveryOptions());
            },
        ];

        yield 'estimatedAvailabilityStatusWrongType' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_AVAILABILITY_STATUS => 42],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertNull($model->getEstimatedAvailabilityStatus());
            },
        ];

        yield 'estimatedAvailableQuantityWrongType' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_AVAILABLE_QUANTITY => 'x'],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertNull($model->getEstimatedAvailableQuantity());
            },
        ];

        yield 'estimatedAvailableQuantityZero' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_AVAILABLE_QUANTITY => 0],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertSame(0, $model->getEstimatedAvailableQuantity());
            },
        ];

        yield 'estimatedRemainingQuantityWrongType' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_REMAINING_QUANTITY => 'x'],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertNull($model->getEstimatedRemainingQuantity());
            },
        ];

        yield 'estimatedRemainingQuantityZero' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_REMAINING_QUANTITY => 0],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertSame(0, $model->getEstimatedRemainingQuantity());
            },
        ];

        yield 'estimatedSoldQuantityWrongType' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_SOLD_QUANTITY => 'x'],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertNull($model->getEstimatedSoldQuantity());
            },
        ];

        yield 'estimatedSoldQuantityZero' => [
            [...$base, EstimatedAvailabilityTransformerInterface::KEY_ESTIMATED_SOLD_QUANTITY => 0],
            static function (EstimatedAvailabilityInterface $model): void {
                self::assertSame(0, $model->getEstimatedSoldQuantity());
            },
        ];
    }

    private function buildTransformer(): EstimatedAvailabilityTransformer
    {
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);

        return new EstimatedAvailabilityTransformer($stringsTransformer);
    }
}
