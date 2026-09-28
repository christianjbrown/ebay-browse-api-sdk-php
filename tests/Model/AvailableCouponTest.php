<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AvailableCoupon;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\CouponConstraintInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AvailableCoupon::class)]
final class AvailableCouponTest extends TestCase
{
    public function test(): void
    {
        $constraint = self::createStub(CouponConstraintInterface::class);
        $discountAmount = self::createStub(ConvertedAmountInterface::class);

        $availableCoupon = new AvailableCoupon();
        self::assertNull($availableCoupon->getConstraint());
        self::assertNull($availableCoupon->getDiscountAmount());
        self::assertNull($availableCoupon->getDiscountType());
        self::assertNull($availableCoupon->getMessage());
        self::assertNull($availableCoupon->getRedemptionCode());
        self::assertNull($availableCoupon->getTermsWebUrl());

        self::assertSame($availableCoupon, $availableCoupon->setConstraint($constraint));
        self::assertSame($availableCoupon, $availableCoupon->setDiscountAmount($discountAmount));
        self::assertSame($availableCoupon, $availableCoupon->setDiscountType('val_discountType'));
        self::assertSame($availableCoupon, $availableCoupon->setMessage('val_message'));
        self::assertSame($availableCoupon, $availableCoupon->setRedemptionCode('val_redemptionCode'));
        self::assertSame($availableCoupon, $availableCoupon->setTermsWebUrl('val_termsWebUrl'));

        self::assertSame($constraint, $availableCoupon->getConstraint());
        self::assertSame($discountAmount, $availableCoupon->getDiscountAmount());
        self::assertSame('val_discountType', $availableCoupon->getDiscountType());
        self::assertSame('val_message', $availableCoupon->getMessage());
        self::assertSame('val_redemptionCode', $availableCoupon->getRedemptionCode());
        self::assertSame('val_termsWebUrl', $availableCoupon->getTermsWebUrl());
    }
}
