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
        $paymentInstructions = ['s'];
        $paymentMethodBrands = [self::createStub(PaymentMethodBrandInterface::class)];
        $sellerInstructions = ['s'];

        $paymentMethod = new PaymentMethod();
        self::assertSame([], $paymentMethod->getPaymentInstructions());
        self::assertSame([], $paymentMethod->getPaymentMethodBrands());
        self::assertNull($paymentMethod->getPaymentMethodType());
        self::assertSame([], $paymentMethod->getSellerInstructions());

        self::assertSame($paymentMethod, $paymentMethod->setPaymentInstructions($paymentInstructions));
        self::assertSame($paymentMethod, $paymentMethod->setPaymentMethodBrands($paymentMethodBrands));
        self::assertSame($paymentMethod, $paymentMethod->setPaymentMethodType('val_paymentMethodType'));
        self::assertSame($paymentMethod, $paymentMethod->setSellerInstructions($sellerInstructions));

        self::assertSame($paymentInstructions, $paymentMethod->getPaymentInstructions());
        self::assertSame($paymentMethodBrands, $paymentMethod->getPaymentMethodBrands());
        self::assertSame('val_paymentMethodType', $paymentMethod->getPaymentMethodType());
        self::assertSame($sellerInstructions, $paymentMethod->getSellerInstructions());
    }
}
