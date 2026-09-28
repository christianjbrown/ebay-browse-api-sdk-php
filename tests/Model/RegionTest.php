<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\Region;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Region::class)]
final class RegionTest extends TestCase
{
    public function test(): void
    {
        $region = new Region();
        self::assertNull($region->getRegionName());
        self::assertNull($region->getRegionType());

        self::assertSame($region, $region->setRegionName('val_regionName'));
        self::assertSame($region, $region->setRegionType('val_regionType'));

        self::assertSame('val_regionName', $region->getRegionName());
        self::assertSame('val_regionType', $region->getRegionType());
    }
}
