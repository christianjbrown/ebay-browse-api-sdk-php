<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\PaymentMethod;
use ChristianBrown\EBay\Browse\Model\PaymentMethodBrandInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentMethod::class)]
final class PaymentMethodTest extends TestCase
{
    public function test(): void
    {
        $paymentMethodBrands = [self::createStub(PaymentMethodBrandInterface::class)];

        $paymentMethod = new PaymentMethod();
        self::assertSame([], $paymentMethod->getPaymentMethodBrands());
        self::assertNull($paymentMethod->getPaymentMethodType());

        self::assertSame($paymentMethod, $paymentMethod->setPaymentMethodBrands($paymentMethodBrands));
        self::assertSame($paymentMethod, $paymentMethod->setPaymentMethodType('v_52'));

        self::assertSame($paymentMethodBrands, $paymentMethod->getPaymentMethodBrands());
        self::assertSame('v_52', $paymentMethod->getPaymentMethodType());
    }
}
