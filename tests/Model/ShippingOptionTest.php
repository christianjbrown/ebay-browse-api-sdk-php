<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\ShippingOption;
use ChristianBrown\EBay\Browse\Model\ShipToLocationInterface;
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
        $shipToLocationUsedForEstimate = self::createStub(ShipToLocationInterface::class);

        $shippingOption = new ShippingOption();
        self::assertNull($shippingOption->getAdditionalShippingCostPerUnit());
        self::assertNull($shippingOption->getCutOffDateUsedForEstimate());
        self::assertNull($shippingOption->getFulfilledThrough());
        self::assertNull($shippingOption->getGuaranteedDelivery());
        self::assertNull($shippingOption->getImportCharges());
        self::assertNull($shippingOption->getMaxEstimatedDeliveryDate());
        self::assertNull($shippingOption->getMinEstimatedDeliveryDate());
        self::assertNull($shippingOption->getQuantityUsedForEstimate());
        self::assertNull($shippingOption->getShippingCarrierCode());
        self::assertNull($shippingOption->getShippingCost());
        self::assertNull($shippingOption->getShippingCostType());
        self::assertNull($shippingOption->getShippingServiceCode());
        self::assertNull($shippingOption->getShipToLocationUsedForEstimate());
        self::assertNull($shippingOption->getTrademarkSymbol());
        self::assertNull($shippingOption->getType());

        self::assertSame($shippingOption, $shippingOption->setAdditionalShippingCostPerUnit($additionalShippingCostPerUnit));
        self::assertSame($shippingOption, $shippingOption->setCutOffDateUsedForEstimate(42));
        self::assertSame($shippingOption, $shippingOption->setFulfilledThrough('val_fulfilledThrough'));
        self::assertSame($shippingOption, $shippingOption->setGuaranteedDelivery(false));
        self::assertSame($shippingOption, $shippingOption->setImportCharges($importCharges));
        self::assertSame($shippingOption, $shippingOption->setMaxEstimatedDeliveryDate(42));
        self::assertSame($shippingOption, $shippingOption->setMinEstimatedDeliveryDate(42));
        self::assertSame($shippingOption, $shippingOption->setQuantityUsedForEstimate(42));
        self::assertSame($shippingOption, $shippingOption->setShippingCarrierCode('val_shippingCarrierCode'));
        self::assertSame($shippingOption, $shippingOption->setShippingCost($shippingCost));
        self::assertSame($shippingOption, $shippingOption->setShippingCostType('val_shippingCostType'));
        self::assertSame($shippingOption, $shippingOption->setShippingServiceCode('val_shippingServiceCode'));
        self::assertSame($shippingOption, $shippingOption->setShipToLocationUsedForEstimate($shipToLocationUsedForEstimate));
        self::assertSame($shippingOption, $shippingOption->setTrademarkSymbol('val_trademarkSymbol'));
        self::assertSame($shippingOption, $shippingOption->setType('val_type'));

        self::assertSame($additionalShippingCostPerUnit, $shippingOption->getAdditionalShippingCostPerUnit());
        self::assertSame(42, $shippingOption->getCutOffDateUsedForEstimate());
        self::assertSame('val_fulfilledThrough', $shippingOption->getFulfilledThrough());
        self::assertFalse($shippingOption->getGuaranteedDelivery());
        self::assertSame($importCharges, $shippingOption->getImportCharges());
        self::assertSame(42, $shippingOption->getMaxEstimatedDeliveryDate());
        self::assertSame(42, $shippingOption->getMinEstimatedDeliveryDate());
        self::assertSame(42, $shippingOption->getQuantityUsedForEstimate());
        self::assertSame('val_shippingCarrierCode', $shippingOption->getShippingCarrierCode());
        self::assertSame($shippingCost, $shippingOption->getShippingCost());
        self::assertSame('val_shippingCostType', $shippingOption->getShippingCostType());
        self::assertSame('val_shippingServiceCode', $shippingOption->getShippingServiceCode());
        self::assertSame($shipToLocationUsedForEstimate, $shippingOption->getShipToLocationUsedForEstimate());
        self::assertSame('val_trademarkSymbol', $shippingOption->getTrademarkSymbol());
        self::assertSame('val_type', $shippingOption->getType());
    }
}
