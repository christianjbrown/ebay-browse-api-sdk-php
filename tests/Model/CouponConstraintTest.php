<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\CouponConstraint;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CouponConstraint::class)]
final class CouponConstraintTest extends TestCase
{
    public function test(): void
    {
        $couponConstraint = new CouponConstraint();
        self::assertNull($couponConstraint->getExpirationDate());

        self::assertSame($couponConstraint, $couponConstraint->setExpirationDate('val_expirationDate'));

        self::assertSame('val_expirationDate', $couponConstraint->getExpirationDate());
    }
}
