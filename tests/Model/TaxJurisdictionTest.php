<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\RegionInterface;
use ChristianBrown\EBay\Browse\Model\TaxJurisdiction;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TaxJurisdiction::class)]
final class TaxJurisdictionTest extends TestCase
{
    public function test(): void
    {
        $region = self::createStub(RegionInterface::class);

        $taxJurisdiction = new TaxJurisdiction();
        self::assertNull($taxJurisdiction->getRegion());
        self::assertNull($taxJurisdiction->getTaxJurisdictionId());

        self::assertSame($taxJurisdiction, $taxJurisdiction->setRegion($region));
        self::assertSame($taxJurisdiction, $taxJurisdiction->setTaxJurisdictionId('val_taxJurisdictionId'));

        self::assertSame($region, $taxJurisdiction->getRegion());
        self::assertSame('val_taxJurisdictionId', $taxJurisdiction->getTaxJurisdictionId());
    }
}
