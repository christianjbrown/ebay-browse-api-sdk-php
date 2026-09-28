<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\LegalAddress;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LegalAddress::class)]
final class LegalAddressTest extends TestCase
{
    public function test(): void
    {
        $legalAddress = new LegalAddress();
        self::assertNull($legalAddress->getAddressLine1());
        self::assertNull($legalAddress->getAddressLine2());
        self::assertNull($legalAddress->getCity());
        self::assertNull($legalAddress->getCountry());
        self::assertNull($legalAddress->getCountryName());
        self::assertNull($legalAddress->getCounty());
        self::assertNull($legalAddress->getPostalCode());
        self::assertNull($legalAddress->getStateOrProvince());

        self::assertSame($legalAddress, $legalAddress->setAddressLine1('val_addressLine1'));
        self::assertSame($legalAddress, $legalAddress->setAddressLine2('val_addressLine2'));
        self::assertSame($legalAddress, $legalAddress->setCity('val_city'));
        self::assertSame($legalAddress, $legalAddress->setCountry('val_country'));
        self::assertSame($legalAddress, $legalAddress->setCountryName('val_countryName'));
        self::assertSame($legalAddress, $legalAddress->setCounty('val_county'));
        self::assertSame($legalAddress, $legalAddress->setPostalCode('val_postalCode'));
        self::assertSame($legalAddress, $legalAddress->setStateOrProvince('val_stateOrProvince'));

        self::assertSame('val_addressLine1', $legalAddress->getAddressLine1());
        self::assertSame('val_addressLine2', $legalAddress->getAddressLine2());
        self::assertSame('val_city', $legalAddress->getCity());
        self::assertSame('val_country', $legalAddress->getCountry());
        self::assertSame('val_countryName', $legalAddress->getCountryName());
        self::assertSame('val_county', $legalAddress->getCounty());
        self::assertSame('val_postalCode', $legalAddress->getPostalCode());
        self::assertSame('val_stateOrProvince', $legalAddress->getStateOrProvince());
    }
}
