<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\AvailableCoupon;
use ChristianBrown\EBay\Browse\Model\AvailableCouponInterface;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\CouponConstraintInterface;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponTransformer;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\CouponConstraintTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(AvailableCoupon::class)]
#[CoversClass(AvailableCouponTransformer::class)]
final class AvailableCouponTransformerTest extends TestCase
{
    private ?ConvertedAmountInterface $convertedAmount = null;
    private ?CouponConstraintInterface $couponConstraint = null;

    public function testTransform(): void
    {
        $data = [
            AvailableCouponTransformerInterface::KEY_CONSTRAINT => ['raw_constraint'],
            AvailableCouponTransformerInterface::KEY_DISCOUNT_AMOUNT => ['raw_discountAmount'],
            AvailableCouponTransformerInterface::KEY_DISCOUNT_TYPE => 'v_1',
            AvailableCouponTransformerInterface::KEY_MESSAGE => 'v_2',
            AvailableCouponTransformerInterface::KEY_REDEMPTION_CODE => 'v_3',
            AvailableCouponTransformerInterface::KEY_TERMS_WEB_URL => 'v_4',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($this->couponConstraint, $actual->getConstraint());
        self::assertSame($this->convertedAmount, $actual->getDiscountAmount());
        self::assertSame('v_1', $actual->getDiscountType());
        self::assertSame('v_2', $actual->getMessage());
        self::assertSame('v_3', $actual->getRedemptionCode());
        self::assertSame('v_4', $actual->getTermsWebUrl());
    }

    /**
     * @param array<string, mixed>                    $data
     * @param Closure(AvailableCouponInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(AvailableCouponInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (AvailableCouponInterface $model): void {
                self::assertNull($model->getConstraint());
                self::assertNull($model->getDiscountAmount());
                self::assertNull($model->getDiscountType());
                self::assertNull($model->getMessage());
                self::assertNull($model->getRedemptionCode());
                self::assertNull($model->getTermsWebUrl());
            },
        ];

        yield 'constraintWrongType' => [
            [...$base, AvailableCouponTransformerInterface::KEY_CONSTRAINT => 'x'],
            static function (AvailableCouponInterface $model): void {
                self::assertNull($model->getConstraint());
            },
        ];

        yield 'discountAmountWrongType' => [
            [...$base, AvailableCouponTransformerInterface::KEY_DISCOUNT_AMOUNT => 'x'],
            static function (AvailableCouponInterface $model): void {
                self::assertNull($model->getDiscountAmount());
            },
        ];

        yield 'discountTypeWrongType' => [
            [...$base, AvailableCouponTransformerInterface::KEY_DISCOUNT_TYPE => 42],
            static function (AvailableCouponInterface $model): void {
                self::assertNull($model->getDiscountType());
            },
        ];

        yield 'messageWrongType' => [
            [...$base, AvailableCouponTransformerInterface::KEY_MESSAGE => 42],
            static function (AvailableCouponInterface $model): void {
                self::assertNull($model->getMessage());
            },
        ];

        yield 'redemptionCodeWrongType' => [
            [...$base, AvailableCouponTransformerInterface::KEY_REDEMPTION_CODE => 42],
            static function (AvailableCouponInterface $model): void {
                self::assertNull($model->getRedemptionCode());
            },
        ];

        yield 'termsWebUrlWrongType' => [
            [...$base, AvailableCouponTransformerInterface::KEY_TERMS_WEB_URL => 42],
            static function (AvailableCouponInterface $model): void {
                self::assertNull($model->getTermsWebUrl());
            },
        ];
    }

    private function buildTransformer(): AvailableCouponTransformer
    {
        $this->couponConstraint = self::createStub(CouponConstraintInterface::class);
        $this->convertedAmount = self::createStub(ConvertedAmountInterface::class);

        $convertedAmountTransformer = self::createStub(ConvertedAmountTransformerInterface::class);
        $convertedAmountTransformer->method('transform')->willReturn($this->convertedAmount);
        $couponConstraintTransformer = self::createStub(CouponConstraintTransformerInterface::class);
        $couponConstraintTransformer->method('transform')->willReturn($this->couponConstraint);

        return new AvailableCouponTransformer($convertedAmountTransformer, $couponConstraintTransformer);
    }
}
