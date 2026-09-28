<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\EconomicOperatorInterface;
use ChristianBrown\EBay\Browse\Model\LegalAddressInterface;
use ChristianBrown\EBay\Browse\Model\SellerLegalInfo;
use ChristianBrown\EBay\Browse\Model\SellerLegalInfoInterface;
use ChristianBrown\EBay\Browse\Model\VatDetailInterface;
use ChristianBrown\EBay\Browse\Transformer\EconomicOperatorTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\LegalAddressTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerLegalInfoTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerLegalInfoTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\VatDetailsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(SellerLegalInfo::class)]
#[CoversClass(SellerLegalInfoTransformer::class)]
final class SellerLegalInfoTransformerTest extends TestCase
{
    private ?EconomicOperatorInterface $economicOperator = null;
    private ?LegalAddressInterface $legalAddress = null;
    private ?VatDetailInterface $vatDetail = null;

    public function testTransform(): void
    {
        $data = [
            SellerLegalInfoTransformerInterface::KEY_ECONOMIC_OPERATOR => ['raw_economicOperator'],
            SellerLegalInfoTransformerInterface::KEY_EMAIL => 'v_1',
            SellerLegalInfoTransformerInterface::KEY_FAX => 'v_2',
            SellerLegalInfoTransformerInterface::KEY_IMPRINT => 'v_3',
            SellerLegalInfoTransformerInterface::KEY_LEGAL_CONTACT_FIRST_NAME => 'v_4',
            SellerLegalInfoTransformerInterface::KEY_LEGAL_CONTACT_LAST_NAME => 'v_5',
            SellerLegalInfoTransformerInterface::KEY_NAME => 'v_6',
            SellerLegalInfoTransformerInterface::KEY_PHONE => 'v_7',
            SellerLegalInfoTransformerInterface::KEY_REGISTRATION_NUMBER => 'v_8',
            SellerLegalInfoTransformerInterface::KEY_SELLER_PROVIDED_LEGAL_ADDRESS => ['raw_sellerProvidedLegalAddress'],
            SellerLegalInfoTransformerInterface::KEY_TERMS_OF_SERVICE => 'v_9',
            SellerLegalInfoTransformerInterface::KEY_VAT_DETAILS => ['raw_vatDetails'],
            SellerLegalInfoTransformerInterface::KEY_WEEE_NUMBER => 'v_10',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($this->economicOperator, $actual->getEconomicOperator());
        self::assertSame('v_1', $actual->getEmail());
        self::assertSame('v_2', $actual->getFax());
        self::assertSame('v_3', $actual->getImprint());
        self::assertSame('v_4', $actual->getLegalContactFirstName());
        self::assertSame('v_5', $actual->getLegalContactLastName());
        self::assertSame('v_6', $actual->getName());
        self::assertSame('v_7', $actual->getPhone());
        self::assertSame('v_8', $actual->getRegistrationNumber());
        self::assertSame($this->legalAddress, $actual->getSellerProvidedLegalAddress());
        self::assertSame('v_9', $actual->getTermsOfService());
        self::assertSame([$this->vatDetail], $actual->getVatDetails());
        self::assertSame('v_10', $actual->getWeeeNumber());
    }

    /**
     * @param array<string, mixed>                    $data
     * @param Closure(SellerLegalInfoInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(SellerLegalInfoInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getEconomicOperator());
                self::assertNull($model->getEmail());
                self::assertNull($model->getFax());
                self::assertNull($model->getImprint());
                self::assertNull($model->getLegalContactFirstName());
                self::assertNull($model->getLegalContactLastName());
                self::assertNull($model->getName());
                self::assertNull($model->getPhone());
                self::assertNull($model->getRegistrationNumber());
                self::assertNull($model->getSellerProvidedLegalAddress());
                self::assertNull($model->getTermsOfService());
                self::assertSame([], $model->getVatDetails());
                self::assertNull($model->getWeeeNumber());
            },
        ];

        yield 'economicOperatorWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_ECONOMIC_OPERATOR => 'x'],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getEconomicOperator());
            },
        ];

        yield 'emailWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_EMAIL => 42],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getEmail());
            },
        ];

        yield 'faxWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_FAX => 42],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getFax());
            },
        ];

        yield 'imprintWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_IMPRINT => 42],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getImprint());
            },
        ];

        yield 'legalContactFirstNameWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_LEGAL_CONTACT_FIRST_NAME => 42],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getLegalContactFirstName());
            },
        ];

        yield 'legalContactLastNameWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_LEGAL_CONTACT_LAST_NAME => 42],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getLegalContactLastName());
            },
        ];

        yield 'nameWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_NAME => 42],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getName());
            },
        ];

        yield 'phoneWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_PHONE => 42],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getPhone());
            },
        ];

        yield 'registrationNumberWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_REGISTRATION_NUMBER => 42],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getRegistrationNumber());
            },
        ];

        yield 'sellerProvidedLegalAddressWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_SELLER_PROVIDED_LEGAL_ADDRESS => 'x'],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getSellerProvidedLegalAddress());
            },
        ];

        yield 'termsOfServiceWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_TERMS_OF_SERVICE => 42],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getTermsOfService());
            },
        ];

        yield 'vatDetailsWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_VAT_DETAILS => 'x'],
            static function (SellerLegalInfoInterface $model): void {
                self::assertSame([], $model->getVatDetails());
            },
        ];

        yield 'weeeNumberWrongType' => [
            [...$base, SellerLegalInfoTransformerInterface::KEY_WEEE_NUMBER => 42],
            static function (SellerLegalInfoInterface $model): void {
                self::assertNull($model->getWeeeNumber());
            },
        ];
    }

    private function buildTransformer(): SellerLegalInfoTransformer
    {
        $this->economicOperator = self::createStub(EconomicOperatorInterface::class);
        $this->legalAddress = self::createStub(LegalAddressInterface::class);
        $this->vatDetail = self::createStub(VatDetailInterface::class);

        $economicOperatorTransformer = self::createStub(EconomicOperatorTransformerInterface::class);
        $economicOperatorTransformer->method('transform')->willReturn($this->economicOperator);
        $legalAddressTransformer = self::createStub(LegalAddressTransformerInterface::class);
        $legalAddressTransformer->method('transform')->willReturn($this->legalAddress);
        $vatDetailsTransformer = self::createStub(VatDetailsTransformerInterface::class);
        $vatDetailsTransformer->method('transform')->willReturn([$this->vatDetail]);

        return new SellerLegalInfoTransformer($economicOperatorTransformer, $legalAddressTransformer, $vatDetailsTransformer);
    }
}
