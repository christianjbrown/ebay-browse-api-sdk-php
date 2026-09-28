<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\LegalAddress;
use ChristianBrown\EBay\Browse\Model\LegalAddressInterface;
use ChristianBrown\EBay\Browse\Transformer\LegalAddressTransformer;
use ChristianBrown\EBay\Browse\Transformer\LegalAddressTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LegalAddress::class)]
#[CoversClass(LegalAddressTransformer::class)]
final class LegalAddressTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LegalAddressTransformerInterface::KEY_ADDRESS_LINE1 => 'v_1',
            LegalAddressTransformerInterface::KEY_ADDRESS_LINE2 => 'v_2',
            LegalAddressTransformerInterface::KEY_CITY => 'v_3',
            LegalAddressTransformerInterface::KEY_COUNTRY => 'v_4',
            LegalAddressTransformerInterface::KEY_COUNTRY_NAME => 'v_5',
            LegalAddressTransformerInterface::KEY_COUNTY => 'v_6',
            LegalAddressTransformerInterface::KEY_POSTAL_CODE => 'v_7',
            LegalAddressTransformerInterface::KEY_STATE_OR_PROVINCE => 'v_8',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getAddressLine1());
        self::assertSame('v_2', $actual->getAddressLine2());
        self::assertSame('v_3', $actual->getCity());
        self::assertSame('v_4', $actual->getCountry());
        self::assertSame('v_5', $actual->getCountryName());
        self::assertSame('v_6', $actual->getCounty());
        self::assertSame('v_7', $actual->getPostalCode());
        self::assertSame('v_8', $actual->getStateOrProvince());
    }

    /**
     * @param array<string, mixed>                 $data
     * @param Closure(LegalAddressInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(LegalAddressInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (LegalAddressInterface $model): void {
                self::assertNull($model->getAddressLine1());
                self::assertNull($model->getAddressLine2());
                self::assertNull($model->getCity());
                self::assertNull($model->getCountry());
                self::assertNull($model->getCountryName());
                self::assertNull($model->getCounty());
                self::assertNull($model->getPostalCode());
                self::assertNull($model->getStateOrProvince());
            },
        ];

        yield 'addressLine1WrongType' => [
            [...$base, LegalAddressTransformerInterface::KEY_ADDRESS_LINE1 => 42],
            static function (LegalAddressInterface $model): void {
                self::assertNull($model->getAddressLine1());
            },
        ];

        yield 'addressLine2WrongType' => [
            [...$base, LegalAddressTransformerInterface::KEY_ADDRESS_LINE2 => 42],
            static function (LegalAddressInterface $model): void {
                self::assertNull($model->getAddressLine2());
            },
        ];

        yield 'cityWrongType' => [
            [...$base, LegalAddressTransformerInterface::KEY_CITY => 42],
            static function (LegalAddressInterface $model): void {
                self::assertNull($model->getCity());
            },
        ];

        yield 'countryWrongType' => [
            [...$base, LegalAddressTransformerInterface::KEY_COUNTRY => 42],
            static function (LegalAddressInterface $model): void {
                self::assertNull($model->getCountry());
            },
        ];

        yield 'countryNameWrongType' => [
            [...$base, LegalAddressTransformerInterface::KEY_COUNTRY_NAME => 42],
            static function (LegalAddressInterface $model): void {
                self::assertNull($model->getCountryName());
            },
        ];

        yield 'countyWrongType' => [
            [...$base, LegalAddressTransformerInterface::KEY_COUNTY => 42],
            static function (LegalAddressInterface $model): void {
                self::assertNull($model->getCounty());
            },
        ];

        yield 'postalCodeWrongType' => [
            [...$base, LegalAddressTransformerInterface::KEY_POSTAL_CODE => 42],
            static function (LegalAddressInterface $model): void {
                self::assertNull($model->getPostalCode());
            },
        ];

        yield 'stateOrProvinceWrongType' => [
            [...$base, LegalAddressTransformerInterface::KEY_STATE_OR_PROVINCE => 42],
            static function (LegalAddressInterface $model): void {
                self::assertNull($model->getStateOrProvince());
            },
        ];
    }

    private function buildTransformer(): LegalAddressTransformer
    {

        return new LegalAddressTransformer();
    }
}
