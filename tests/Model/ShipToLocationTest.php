<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ShipToLocation;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShipToLocation::class)]
final class ShipToLocationTest extends TestCase
{
    public function test(): void
    {
        $shipToLocation = new ShipToLocation();
        self::assertNull($shipToLocation->getCountry());
        self::assertNull($shipToLocation->getPostalCode());

        self::assertSame($shipToLocation, $shipToLocation->setCountry('val_country'));
        self::assertSame($shipToLocation, $shipToLocation->setPostalCode('val_postalCode'));

        self::assertSame('val_country', $shipToLocation->getCountry());
        self::assertSame('val_postalCode', $shipToLocation->getPostalCode());
    }
}
