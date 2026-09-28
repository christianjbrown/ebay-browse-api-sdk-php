<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\AddonService;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AddonService::class)]
final class AddonServiceTest extends TestCase
{
    public function test(): void
    {
        $serviceFee = self::createStub(ConvertedAmountInterface::class);

        $addonService = new AddonService();
        self::assertNull($addonService->getSelection());
        self::assertNull($addonService->getServiceFee());
        self::assertNull($addonService->getServiceId());
        self::assertNull($addonService->getServiceType());

        self::assertSame($addonService, $addonService->setSelection('val_selection'));
        self::assertSame($addonService, $addonService->setServiceFee($serviceFee));
        self::assertSame($addonService, $addonService->setServiceId('val_serviceId'));
        self::assertSame($addonService, $addonService->setServiceType('val_serviceType'));

        self::assertSame('val_selection', $addonService->getSelection());
        self::assertSame($serviceFee, $addonService->getServiceFee());
        self::assertSame('val_serviceId', $addonService->getServiceId());
        self::assertSame('val_serviceType', $addonService->getServiceType());
    }
}
