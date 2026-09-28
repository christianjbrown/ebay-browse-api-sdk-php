<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\EconomicOperatorInterface;
use ChristianBrown\EBay\Browse\Model\LegalAddressInterface;
use ChristianBrown\EBay\Browse\Model\SellerLegalInfo;
use ChristianBrown\EBay\Browse\Model\VatDetailInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SellerLegalInfo::class)]
final class SellerLegalInfoTest extends TestCase
{
    public function test(): void
    {
        $economicOperator = self::createStub(EconomicOperatorInterface::class);
        $sellerProvidedLegalAddress = self::createStub(LegalAddressInterface::class);
        $vatDetails = [self::createStub(VatDetailInterface::class)];

        $sellerLegalInfo = new SellerLegalInfo();
        self::assertNull($sellerLegalInfo->getEconomicOperator());
        self::assertNull($sellerLegalInfo->getEmail());
        self::assertNull($sellerLegalInfo->getFax());
        self::assertNull($sellerLegalInfo->getImprint());
        self::assertNull($sellerLegalInfo->getLegalContactFirstName());
        self::assertNull($sellerLegalInfo->getLegalContactLastName());
        self::assertNull($sellerLegalInfo->getName());
        self::assertNull($sellerLegalInfo->getPhone());
        self::assertNull($sellerLegalInfo->getRegistrationNumber());
        self::assertNull($sellerLegalInfo->getSellerProvidedLegalAddress());
        self::assertNull($sellerLegalInfo->getTermsOfService());
        self::assertSame([], $sellerLegalInfo->getVatDetails());
        self::assertNull($sellerLegalInfo->getWeeeNumber());

        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setEconomicOperator($economicOperator));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setEmail('val_email'));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setFax('val_fax'));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setImprint('val_imprint'));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setLegalContactFirstName('val_legalContactFirstName'));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setLegalContactLastName('val_legalContactLastName'));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setName('val_name'));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setPhone('val_phone'));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setRegistrationNumber('val_registrationNumber'));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setSellerProvidedLegalAddress($sellerProvidedLegalAddress));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setTermsOfService('val_termsOfService'));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setVatDetails($vatDetails));
        self::assertSame($sellerLegalInfo, $sellerLegalInfo->setWeeeNumber('val_weeeNumber'));

        self::assertSame($economicOperator, $sellerLegalInfo->getEconomicOperator());
        self::assertSame('val_email', $sellerLegalInfo->getEmail());
        self::assertSame('val_fax', $sellerLegalInfo->getFax());
        self::assertSame('val_imprint', $sellerLegalInfo->getImprint());
        self::assertSame('val_legalContactFirstName', $sellerLegalInfo->getLegalContactFirstName());
        self::assertSame('val_legalContactLastName', $sellerLegalInfo->getLegalContactLastName());
        self::assertSame('val_name', $sellerLegalInfo->getName());
        self::assertSame('val_phone', $sellerLegalInfo->getPhone());
        self::assertSame('val_registrationNumber', $sellerLegalInfo->getRegistrationNumber());
        self::assertSame($sellerProvidedLegalAddress, $sellerLegalInfo->getSellerProvidedLegalAddress());
        self::assertSame('val_termsOfService', $sellerLegalInfo->getTermsOfService());
        self::assertSame($vatDetails, $sellerLegalInfo->getVatDetails());
        self::assertSame('val_weeeNumber', $sellerLegalInfo->getWeeeNumber());
    }
}
