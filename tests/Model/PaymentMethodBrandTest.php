<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\PaymentMethodBrand;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PaymentMethodBrand::class)]
final class PaymentMethodBrandTest extends TestCase
{
    public function test(): void
    {
        $logoImage = self::createStub(ImageInterface::class);

        $paymentMethodBrand = new PaymentMethodBrand();
        self::assertNull($paymentMethodBrand->getLogoImage());
        self::assertNull($paymentMethodBrand->getPaymentMethodBrandType());

        self::assertSame($paymentMethodBrand, $paymentMethodBrand->setLogoImage($logoImage));
        self::assertSame($paymentMethodBrand, $paymentMethodBrand->setPaymentMethodBrandType('v_52'));

        self::assertSame($logoImage, $paymentMethodBrand->getLogoImage());
        self::assertSame('v_52', $paymentMethodBrand->getPaymentMethodBrandType());
    }
}
