<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\EconomicOperator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(EconomicOperator::class)]
final class EconomicOperatorTest extends TestCase
{
    public function test(): void
    {
        $economicOperator = new EconomicOperator();
        self::assertNull($economicOperator->getAddressLine1());
        self::assertNull($economicOperator->getAddressLine2());
        self::assertNull($economicOperator->getCity());
        self::assertNull($economicOperator->getCompanyName());
        self::assertNull($economicOperator->getCountry());
        self::assertNull($economicOperator->getEmail());
        self::assertNull($economicOperator->getPhone());
        self::assertNull($economicOperator->getPostalCode());
        self::assertNull($economicOperator->getStateOrProvince());

        self::assertSame($economicOperator, $economicOperator->setAddressLine1('val_addressLine1'));
        self::assertSame($economicOperator, $economicOperator->setAddressLine2('val_addressLine2'));
        self::assertSame($economicOperator, $economicOperator->setCity('val_city'));
        self::assertSame($economicOperator, $economicOperator->setCompanyName('val_companyName'));
        self::assertSame($economicOperator, $economicOperator->setCountry('val_country'));
        self::assertSame($economicOperator, $economicOperator->setEmail('val_email'));
        self::assertSame($economicOperator, $economicOperator->setPhone('val_phone'));
        self::assertSame($economicOperator, $economicOperator->setPostalCode('val_postalCode'));
        self::assertSame($economicOperator, $economicOperator->setStateOrProvince('val_stateOrProvince'));

        self::assertSame('val_addressLine1', $economicOperator->getAddressLine1());
        self::assertSame('val_addressLine2', $economicOperator->getAddressLine2());
        self::assertSame('val_city', $economicOperator->getCity());
        self::assertSame('val_companyName', $economicOperator->getCompanyName());
        self::assertSame('val_country', $economicOperator->getCountry());
        self::assertSame('val_email', $economicOperator->getEmail());
        self::assertSame('val_phone', $economicOperator->getPhone());
        self::assertSame('val_postalCode', $economicOperator->getPostalCode());
        self::assertSame('val_stateOrProvince', $economicOperator->getStateOrProvince());
    }
}
