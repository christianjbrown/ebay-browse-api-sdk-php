<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\ShippingOption;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShippingOption::class)]
final class ShippingOptionTest extends TestCase
{
    public function test(): void
    {
        $additionalShippingCostPerUnit = self::createStub(ConvertedAmountInterface::class);
        $importCharges = self::createStub(ConvertedAmountInterface::class);
        $shippingCost = self::createStub(ConvertedAmountInterface::class);

        $shippingOption = new ShippingOption();
        self::assertNull($shippingOption->getAdditionalShippingCostPerUnit());
        self::assertNull($shippingOption->getCutOffDateUsedForEstimate());
        self::assertNull($shippingOption->getGuaranteedDelivery());
        self::assertNull($shippingOption->getImportCharges());
        self::assertNull($shippingOption->getMaxEstimatedDeliveryDate());
        self::assertNull($shippingOption->getMinEstimatedDeliveryDate());
        self::assertNull($shippingOption->getQuantityUsedForEstimate());
        self::assertNull($shippingOption->getShippingCarrierCode());
        self::assertNull($shippingOption->getShippingCost());
        self::assertNull($shippingOption->getShippingCostType());
        self::assertNull($shippingOption->getShippingServiceCode());
        self::assertNull($shippingOption->getType());

        self::assertSame($shippingOption, $shippingOption->setAdditionalShippingCostPerUnit($additionalShippingCostPerUnit));
        self::assertSame($shippingOption, $shippingOption->setCutOffDateUsedForEstimate(1700000052));
        self::assertSame($shippingOption, $shippingOption->setGuaranteedDelivery(false));
        self::assertSame($shippingOption, $shippingOption->setImportCharges($importCharges));
        self::assertSame($shippingOption, $shippingOption->setMaxEstimatedDeliveryDate(1700000055));
        self::assertSame($shippingOption, $shippingOption->setMinEstimatedDeliveryDate(1700000056));
        self::assertSame($shippingOption, $shippingOption->setQuantityUsedForEstimate(157));
        self::assertSame($shippingOption, $shippingOption->setShippingCarrierCode('v_58'));
        self::assertSame($shippingOption, $shippingOption->setShippingCost($shippingCost));
        self::assertSame($shippingOption, $shippingOption->setShippingCostType('v_60'));
        self::assertSame($shippingOption, $shippingOption->setShippingServiceCode('v_61'));
        self::assertSame($shippingOption, $shippingOption->setType('v_62'));

        self::assertSame($additionalShippingCostPerUnit, $shippingOption->getAdditionalShippingCostPerUnit());
        self::assertSame(1700000052, $shippingOption->getCutOffDateUsedForEstimate());
        self::assertFalse($shippingOption->getGuaranteedDelivery());
        self::assertSame($importCharges, $shippingOption->getImportCharges());
        self::assertSame(1700000055, $shippingOption->getMaxEstimatedDeliveryDate());
        self::assertSame(1700000056, $shippingOption->getMinEstimatedDeliveryDate());
        self::assertSame(157, $shippingOption->getQuantityUsedForEstimate());
        self::assertSame('v_58', $shippingOption->getShippingCarrierCode());
        self::assertSame($shippingCost, $shippingOption->getShippingCost());
        self::assertSame('v_60', $shippingOption->getShippingCostType());
        self::assertSame('v_61', $shippingOption->getShippingServiceCode());
        self::assertSame('v_62', $shippingOption->getType());
    }
}
