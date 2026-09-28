<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\CompanyAddress;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CompanyAddress::class)]
final class CompanyAddressTest extends TestCase
{
    public function test(): void
    {
        $companyAddress = new CompanyAddress();
        self::assertNull($companyAddress->getAddressLine1());
        self::assertNull($companyAddress->getAddressLine2());
        self::assertNull($companyAddress->getCity());
        self::assertNull($companyAddress->getCompanyName());
        self::assertNull($companyAddress->getContactUrl());
        self::assertNull($companyAddress->getCountry());
        self::assertNull($companyAddress->getCountryName());
        self::assertNull($companyAddress->getCounty());
        self::assertNull($companyAddress->getEmail());
        self::assertNull($companyAddress->getPhone());
        self::assertNull($companyAddress->getPostalCode());
        self::assertNull($companyAddress->getStateOrProvince());

        self::assertSame($companyAddress, $companyAddress->setAddressLine1('val_addressLine1'));
        self::assertSame($companyAddress, $companyAddress->setAddressLine2('val_addressLine2'));
        self::assertSame($companyAddress, $companyAddress->setCity('val_city'));
        self::assertSame($companyAddress, $companyAddress->setCompanyName('val_companyName'));
        self::assertSame($companyAddress, $companyAddress->setContactUrl('val_contactUrl'));
        self::assertSame($companyAddress, $companyAddress->setCountry('val_country'));
        self::assertSame($companyAddress, $companyAddress->setCountryName('val_countryName'));
        self::assertSame($companyAddress, $companyAddress->setCounty('val_county'));
        self::assertSame($companyAddress, $companyAddress->setEmail('val_email'));
        self::assertSame($companyAddress, $companyAddress->setPhone('val_phone'));
        self::assertSame($companyAddress, $companyAddress->setPostalCode('val_postalCode'));
        self::assertSame($companyAddress, $companyAddress->setStateOrProvince('val_stateOrProvince'));

        self::assertSame('val_addressLine1', $companyAddress->getAddressLine1());
        self::assertSame('val_addressLine2', $companyAddress->getAddressLine2());
        self::assertSame('val_city', $companyAddress->getCity());
        self::assertSame('val_companyName', $companyAddress->getCompanyName());
        self::assertSame('val_contactUrl', $companyAddress->getContactUrl());
        self::assertSame('val_country', $companyAddress->getCountry());
        self::assertSame('val_countryName', $companyAddress->getCountryName());
        self::assertSame('val_county', $companyAddress->getCounty());
        self::assertSame('val_email', $companyAddress->getEmail());
        self::assertSame('val_phone', $companyAddress->getPhone());
        self::assertSame('val_postalCode', $companyAddress->getPostalCode());
        self::assertSame('val_stateOrProvince', $companyAddress->getStateOrProvince());
    }
}
