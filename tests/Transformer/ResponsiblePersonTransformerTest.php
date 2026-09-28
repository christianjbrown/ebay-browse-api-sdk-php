<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ResponsiblePerson;
use ChristianBrown\EBay\Browse\Model\ResponsiblePersonInterface;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonTransformer;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ResponsiblePerson::class)]
#[CoversClass(ResponsiblePersonTransformer::class)]
final class ResponsiblePersonTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ResponsiblePersonTransformerInterface::KEY_ADDRESS_LINE1 => 'v_1',
            ResponsiblePersonTransformerInterface::KEY_ADDRESS_LINE2 => 'v_2',
            ResponsiblePersonTransformerInterface::KEY_CITY => 'v_3',
            ResponsiblePersonTransformerInterface::KEY_COMPANY_NAME => 'v_4',
            ResponsiblePersonTransformerInterface::KEY_CONTACT_URL => 'v_5',
            ResponsiblePersonTransformerInterface::KEY_COUNTRY => 'v_6',
            ResponsiblePersonTransformerInterface::KEY_COUNTRY_NAME => 'v_7',
            ResponsiblePersonTransformerInterface::KEY_COUNTY => 'v_8',
            ResponsiblePersonTransformerInterface::KEY_EMAIL => 'v_9',
            ResponsiblePersonTransformerInterface::KEY_PHONE => 'v_10',
            ResponsiblePersonTransformerInterface::KEY_POSTAL_CODE => 'v_11',
            ResponsiblePersonTransformerInterface::KEY_STATE_OR_PROVINCE => 'v_12',
            ResponsiblePersonTransformerInterface::KEY_TYPES => ['raw_types'],
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
        self::assertSame(['s'], $actual->getTypes());
    }

    /**
     * @param array<string, mixed>                      $data
     * @param Closure(ResponsiblePersonInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ResponsiblePersonInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ResponsiblePersonInterface $model): void {
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
                self::assertSame([], $model->getTypes());
            },
        ];

        yield 'addressLine1WrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_ADDRESS_LINE1 => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getAddressLine1());
            },
        ];

        yield 'addressLine2WrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_ADDRESS_LINE2 => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getAddressLine2());
            },
        ];

        yield 'cityWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_CITY => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getCity());
            },
        ];

        yield 'companyNameWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_COMPANY_NAME => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getCompanyName());
            },
        ];

        yield 'contactUrlWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_CONTACT_URL => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getContactUrl());
            },
        ];

        yield 'countryWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_COUNTRY => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getCountry());
            },
        ];

        yield 'countryNameWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_COUNTRY_NAME => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getCountryName());
            },
        ];

        yield 'countyWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_COUNTY => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getCounty());
            },
        ];

        yield 'emailWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_EMAIL => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getEmail());
            },
        ];

        yield 'phoneWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_PHONE => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getPhone());
            },
        ];

        yield 'postalCodeWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_POSTAL_CODE => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getPostalCode());
            },
        ];

        yield 'stateOrProvinceWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_STATE_OR_PROVINCE => 42],
            static function (ResponsiblePersonInterface $model): void {
                self::assertNull($model->getStateOrProvince());
            },
        ];

        yield 'typesWrongType' => [
            [...$base, ResponsiblePersonTransformerInterface::KEY_TYPES => 'x'],
            static function (ResponsiblePersonInterface $model): void {
                self::assertSame([], $model->getTypes());
            },
        ];
    }

    private function buildTransformer(): ResponsiblePersonTransformer
    {

        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);

        return new ResponsiblePersonTransformer($stringsTransformer);
    }
}
