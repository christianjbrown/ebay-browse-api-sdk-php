<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\CompanyAddress;
use ChristianBrown\EBay\Browse\Model\CompanyAddressInterface;
use ChristianBrown\EBay\Browse\Transformer\CompanyAddressTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompanyAddressTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(CompanyAddress::class)]
#[CoversClass(CompanyAddressTransformer::class)]
final class CompanyAddressTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            CompanyAddressTransformerInterface::KEY_ADDRESS_LINE1 => 'v_1',
            CompanyAddressTransformerInterface::KEY_ADDRESS_LINE2 => 'v_2',
            CompanyAddressTransformerInterface::KEY_CITY => 'v_3',
            CompanyAddressTransformerInterface::KEY_COMPANY_NAME => 'v_4',
            CompanyAddressTransformerInterface::KEY_CONTACT_URL => 'v_5',
            CompanyAddressTransformerInterface::KEY_COUNTRY => 'v_6',
            CompanyAddressTransformerInterface::KEY_COUNTRY_NAME => 'v_7',
            CompanyAddressTransformerInterface::KEY_COUNTY => 'v_8',
            CompanyAddressTransformerInterface::KEY_EMAIL => 'v_9',
            CompanyAddressTransformerInterface::KEY_PHONE => 'v_10',
            CompanyAddressTransformerInterface::KEY_POSTAL_CODE => 'v_11',
            CompanyAddressTransformerInterface::KEY_STATE_OR_PROVINCE => 'v_12',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getAddressLine1());
        self::assertSame('v_2', $actual->getAddressLine2());
        self::assertSame('v_3', $actual->getCity());
        self::assertSame('v_4', $actual->getCompanyName());
        self::assertSame('v_5', $actual->getContactUrl());
        self::assertSame('v_6', $actual->getCountry());
        self::assertSame('v_7', $actual->getCountryName());
        self::assertSame('v_8', $actual->getCounty());
        self::assertSame('v_9', $actual->getEmail());
        self::assertSame('v_10', $actual->getPhone());
        self::assertSame('v_11', $actual->getPostalCode());
        self::assertSame('v_12', $actual->getStateOrProvince());
    }

    /**
     * @param array<string, mixed>                   $data
     * @param Closure(CompanyAddressInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(CompanyAddressInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getAddressLine1());
                self::assertNull($model->getAddressLine2());
                self::assertNull($model->getCity());
                self::assertNull($model->getCompanyName());
                self::assertNull($model->getContactUrl());
                self::assertNull($model->getCountry());
                self::assertNull($model->getCountryName());
                self::assertNull($model->getCounty());
                self::assertNull($model->getEmail());
                self::assertNull($model->getPhone());
                self::assertNull($model->getPostalCode());
                self::assertNull($model->getStateOrProvince());
            },
        ];

        yield 'addressLine1WrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_ADDRESS_LINE1 => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getAddressLine1());
            },
        ];

        yield 'addressLine2WrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_ADDRESS_LINE2 => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getAddressLine2());
            },
        ];

        yield 'cityWrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_CITY => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getCity());
            },
        ];

        yield 'companyNameWrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_COMPANY_NAME => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getCompanyName());
            },
        ];

        yield 'contactUrlWrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_CONTACT_URL => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getContactUrl());
            },
        ];

        yield 'countryWrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_COUNTRY => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getCountry());
            },
        ];

        yield 'countryNameWrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_COUNTRY_NAME => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getCountryName());
            },
        ];

        yield 'countyWrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_COUNTY => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getCounty());
            },
        ];

        yield 'emailWrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_EMAIL => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getEmail());
            },
        ];

        yield 'phoneWrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_PHONE => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getPhone());
            },
        ];

        yield 'postalCodeWrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_POSTAL_CODE => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getPostalCode());
            },
        ];

        yield 'stateOrProvinceWrongType' => [
            [...$base, CompanyAddressTransformerInterface::KEY_STATE_OR_PROVINCE => 42],
            static function (CompanyAddressInterface $model): void {
                self::assertNull($model->getStateOrProvince());
            },
        ];
    }

    private function buildTransformer(): CompanyAddressTransformer
    {

        return new CompanyAddressTransformer();
    }
}
