<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ShipToLocations;
use ChristianBrown\EBay\Browse\Model\ShipToRegionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShipToLocations::class)]
final class ShipToLocationsTest extends TestCase
{
    public function test(): void
    {
        $regionExcluded = [self::createStub(ShipToRegionInterface::class)];
        $regionIncluded = [self::createStub(ShipToRegionInterface::class)];

        $shipToLocations = new ShipToLocations();
        self::assertSame([], $shipToLocations->getRegionExcluded());
        self::assertSame([], $shipToLocations->getRegionIncluded());

        self::assertSame($shipToLocations, $shipToLocations->setRegionExcluded($regionExcluded));
        self::assertSame($shipToLocations, $shipToLocations->setRegionIncluded($regionIncluded));

        self::assertSame($regionExcluded, $shipToLocations->getRegionExcluded());
        self::assertSame($regionIncluded, $shipToLocations->getRegionIncluded());
    }
}
