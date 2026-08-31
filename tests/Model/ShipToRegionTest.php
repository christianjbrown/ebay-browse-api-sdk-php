<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ShipToRegion;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShipToRegion::class)]
final class ShipToRegionTest extends TestCase
{
    public function test(): void
    {
        $shipToRegion = new ShipToRegion();
        self::assertNull($shipToRegion->getRegionId());
        self::assertNull($shipToRegion->getRegionName());
        self::assertNull($shipToRegion->getRegionType());

        self::assertSame($shipToRegion, $shipToRegion->setRegionId('v_51'));
        self::assertSame($shipToRegion, $shipToRegion->setRegionName('v_52'));
        self::assertSame($shipToRegion, $shipToRegion->setRegionType('v_53'));

        self::assertSame('v_51', $shipToRegion->getRegionId());
        self::assertSame('v_52', $shipToRegion->getRegionName());
        self::assertSame('v_53', $shipToRegion->getRegionType());
    }
}
