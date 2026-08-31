<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ReturnTerms;
use ChristianBrown\EBay\Browse\Model\ReturnTermsInterface;
use ChristianBrown\EBay\Browse\Model\TimeDurationInterface;
use ChristianBrown\EBay\Browse\Transformer\ReturnTermsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ReturnTermsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TimeDurationTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReturnTerms::class)]
#[CoversClass(ReturnTermsTransformer::class)]
final class ReturnTermsTransformerTest extends TestCase
{
    private ?TimeDurationInterface $timeDuration = null;

    public function testTransform(): void
    {
        $data = [
            ReturnTermsTransformerInterface::KEY_EXTENDED_HOLIDAY_RETURNS_OFFERED => true,
            ReturnTermsTransformerInterface::KEY_REFUND_METHOD => 'v_1',
            ReturnTermsTransformerInterface::KEY_RESTOCKING_FEE_PERCENTAGE => 'v_2',
            ReturnTermsTransformerInterface::KEY_RETURN_INSTRUCTIONS => 'v_3',
            ReturnTermsTransformerInterface::KEY_RETURN_METHOD => 'v_4',
            ReturnTermsTransformerInterface::KEY_RETURN_PERIOD => ['raw_returnPeriod'],
            ReturnTermsTransformerInterface::KEY_RETURN_SHIPPING_COST_PAYER => 'v_6',
            ReturnTermsTransformerInterface::KEY_RETURNS_ACCEPTED => true,
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertTrue($actual->getExtendedHolidayReturnsOffered());
        self::assertSame('v_1', $actual->getRefundMethod());
        self::assertSame('v_2', $actual->getRestockingFeePercentage());
        self::assertSame('v_3', $actual->getReturnInstructions());
        self::assertSame('v_4', $actual->getReturnMethod());
        self::assertSame($this->timeDuration, $actual->getReturnPeriod());
        self::assertSame('v_6', $actual->getReturnShippingCostPayer());
        self::assertTrue($actual->getReturnsAccepted());
    }

    /**
     * @param array<string, mixed>                $data
     * @param Closure(ReturnTermsInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ReturnTermsInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ReturnTermsInterface $model): void {
                self::assertNull($model->getExtendedHolidayReturnsOffered());
                self::assertNull($model->getRefundMethod());
                self::assertNull($model->getRestockingFeePercentage());
                self::assertNull($model->getReturnInstructions());
                self::assertNull($model->getReturnMethod());
                self::assertNull($model->getReturnPeriod());
                self::assertNull($model->getReturnShippingCostPayer());
                self::assertNull($model->getReturnsAccepted());
            },
        ];

        yield 'extendedHolidayReturnsOfferedWrongType' => [
            [...$base, ReturnTermsTransformerInterface::KEY_EXTENDED_HOLIDAY_RETURNS_OFFERED => 'x'],
            static function (ReturnTermsInterface $model): void {
                self::assertNull($model->getExtendedHolidayReturnsOffered());
            },
        ];

        yield 'extendedHolidayReturnsOfferedFalse' => [
            [...$base, ReturnTermsTransformerInterface::KEY_EXTENDED_HOLIDAY_RETURNS_OFFERED => false],
            static function (ReturnTermsInterface $model): void {
                self::assertFalse($model->getExtendedHolidayReturnsOffered());
            },
        ];

        yield 'refundMethodWrongType' => [
            [...$base, ReturnTermsTransformerInterface::KEY_REFUND_METHOD => 42],
            static function (ReturnTermsInterface $model): void {
                self::assertNull($model->getRefundMethod());
            },
        ];

        yield 'restockingFeePercentageWrongType' => [
            [...$base, ReturnTermsTransformerInterface::KEY_RESTOCKING_FEE_PERCENTAGE => 42],
            static function (ReturnTermsInterface $model): void {
                self::assertNull($model->getRestockingFeePercentage());
            },
        ];

        yield 'returnInstructionsWrongType' => [
            [...$base, ReturnTermsTransformerInterface::KEY_RETURN_INSTRUCTIONS => 42],
            static function (ReturnTermsInterface $model): void {
                self::assertNull($model->getReturnInstructions());
            },
        ];

        yield 'returnMethodWrongType' => [
            [...$base, ReturnTermsTransformerInterface::KEY_RETURN_METHOD => 42],
            static function (ReturnTermsInterface $model): void {
                self::assertNull($model->getReturnMethod());
            },
        ];

        yield 'returnPeriodWrongType' => [
            [...$base, ReturnTermsTransformerInterface::KEY_RETURN_PERIOD => 'x'],
            static function (ReturnTermsInterface $model): void {
                self::assertNull($model->getReturnPeriod());
            },
        ];

        yield 'returnShippingCostPayerWrongType' => [
            [...$base, ReturnTermsTransformerInterface::KEY_RETURN_SHIPPING_COST_PAYER => 42],
            static function (ReturnTermsInterface $model): void {
                self::assertNull($model->getReturnShippingCostPayer());
            },
        ];

        yield 'returnsAcceptedWrongType' => [
            [...$base, ReturnTermsTransformerInterface::KEY_RETURNS_ACCEPTED => 'x'],
            static function (ReturnTermsInterface $model): void {
                self::assertNull($model->getReturnsAccepted());
            },
        ];

        yield 'returnsAcceptedFalse' => [
            [...$base, ReturnTermsTransformerInterface::KEY_RETURNS_ACCEPTED => false],
            static function (ReturnTermsInterface $model): void {
                self::assertFalse($model->getReturnsAccepted());
            },
        ];
    }

    private function buildTransformer(): ReturnTermsTransformer
    {
        $this->timeDuration = self::createStub(TimeDurationInterface::class);

        $timeDurationTransformer = self::createStub(TimeDurationTransformerInterface::class);
        $timeDurationTransformer->method('transform')->willReturn($this->timeDuration);

        return new ReturnTermsTransformer($timeDurationTransformer);
    }
}
