<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\Tax;
use ChristianBrown\EBay\Browse\Model\TaxJurisdictionInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Tax::class)]
final class TaxTest extends TestCase
{
    public function test(): void
    {
        $taxJurisdiction = self::createStub(TaxJurisdictionInterface::class);

        $tax = new Tax();
        self::assertNull($tax->getEbayCollectAndRemitTax());
        self::assertNull($tax->getIncludedInPrice());
        self::assertNull($tax->getShippingAndHandlingTaxed());
        self::assertNull($tax->getTaxJurisdiction());
        self::assertNull($tax->getTaxPercentage());
        self::assertNull($tax->getTaxType());

        self::assertSame($tax, $tax->setEbayCollectAndRemitTax(false));
        self::assertSame($tax, $tax->setIncludedInPrice(false));
        self::assertSame($tax, $tax->setShippingAndHandlingTaxed(false));
        self::assertSame($tax, $tax->setTaxJurisdiction($taxJurisdiction));
        self::assertSame($tax, $tax->setTaxPercentage('val_taxPercentage'));
        self::assertSame($tax, $tax->setTaxType('val_taxType'));

        self::assertFalse($tax->getEbayCollectAndRemitTax());
        self::assertFalse($tax->getIncludedInPrice());
        self::assertFalse($tax->getShippingAndHandlingTaxed());
        self::assertSame($taxJurisdiction, $tax->getTaxJurisdiction());
        self::assertSame('val_taxPercentage', $tax->getTaxPercentage());
        self::assertSame('val_taxType', $tax->getTaxType());
    }
}
