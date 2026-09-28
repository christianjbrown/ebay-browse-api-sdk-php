<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\ResponsiblePerson;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ResponsiblePerson::class)]
final class ResponsiblePersonTest extends TestCase
{
    public function test(): void
    {
        $types = ['s'];

        $responsiblePerson = new ResponsiblePerson();
        self::assertNull($responsiblePerson->getAddressLine1());
        self::assertNull($responsiblePerson->getAddressLine2());
        self::assertNull($responsiblePerson->getCity());
        self::assertNull($responsiblePerson->getCompanyName());
        self::assertNull($responsiblePerson->getContactUrl());
        self::assertNull($responsiblePerson->getCountry());
        self::assertNull($responsiblePerson->getCountryName());
        self::assertNull($responsiblePerson->getCounty());
        self::assertNull($responsiblePerson->getEmail());
        self::assertNull($responsiblePerson->getPhone());
        self::assertNull($responsiblePerson->getPostalCode());
        self::assertNull($responsiblePerson->getStateOrProvince());
        self::assertSame([], $responsiblePerson->getTypes());

        self::assertSame($responsiblePerson, $responsiblePerson->setAddressLine1('val_addressLine1'));
        self::assertSame($responsiblePerson, $responsiblePerson->setAddressLine2('val_addressLine2'));
        self::assertSame($responsiblePerson, $responsiblePerson->setCity('val_city'));
        self::assertSame($responsiblePerson, $responsiblePerson->setCompanyName('val_companyName'));
        self::assertSame($responsiblePerson, $responsiblePerson->setContactUrl('val_contactUrl'));
        self::assertSame($responsiblePerson, $responsiblePerson->setCountry('val_country'));
        self::assertSame($responsiblePerson, $responsiblePerson->setCountryName('val_countryName'));
        self::assertSame($responsiblePerson, $responsiblePerson->setCounty('val_county'));
        self::assertSame($responsiblePerson, $responsiblePerson->setEmail('val_email'));
        self::assertSame($responsiblePerson, $responsiblePerson->setPhone('val_phone'));
        self::assertSame($responsiblePerson, $responsiblePerson->setPostalCode('val_postalCode'));
        self::assertSame($responsiblePerson, $responsiblePerson->setStateOrProvince('val_stateOrProvince'));
        self::assertSame($responsiblePerson, $responsiblePerson->setTypes($types));

        self::assertSame('val_addressLine1', $responsiblePerson->getAddressLine1());
        self::assertSame('val_addressLine2', $responsiblePerson->getAddressLine2());
        self::assertSame('val_city', $responsiblePerson->getCity());
        self::assertSame('val_companyName', $responsiblePerson->getCompanyName());
        self::assertSame('val_contactUrl', $responsiblePerson->getContactUrl());
        self::assertSame('val_country', $responsiblePerson->getCountry());
        self::assertSame('val_countryName', $responsiblePerson->getCountryName());
        self::assertSame('val_county', $responsiblePerson->getCounty());
        self::assertSame('val_email', $responsiblePerson->getEmail());
        self::assertSame('val_phone', $responsiblePerson->getPhone());
        self::assertSame('val_postalCode', $responsiblePerson->getPostalCode());
        self::assertSame('val_stateOrProvince', $responsiblePerson->getStateOrProvince());
        self::assertSame($types, $responsiblePerson->getTypes());
    }
}
