<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\EconomicOperator;
use ChristianBrown\EBay\Browse\Model\EconomicOperatorInterface;
use ChristianBrown\EBay\Browse\Transformer\EconomicOperatorTransformer;
use ChristianBrown\EBay\Browse\Transformer\EconomicOperatorTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EconomicOperator::class)]
#[CoversClass(EconomicOperatorTransformer::class)]
final class EconomicOperatorTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EconomicOperatorTransformerInterface::KEY_ADDRESS_LINE1 => 'v_1',
            EconomicOperatorTransformerInterface::KEY_ADDRESS_LINE2 => 'v_2',
            EconomicOperatorTransformerInterface::KEY_CITY => 'v_3',
            EconomicOperatorTransformerInterface::KEY_COMPANY_NAME => 'v_4',
            EconomicOperatorTransformerInterface::KEY_COUNTRY => 'v_5',
            EconomicOperatorTransformerInterface::KEY_EMAIL => 'v_6',
            EconomicOperatorTransformerInterface::KEY_PHONE => 'v_7',
            EconomicOperatorTransformerInterface::KEY_POSTAL_CODE => 'v_8',
            EconomicOperatorTransformerInterface::KEY_STATE_OR_PROVINCE => 'v_9',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getAddressLine1());
        self::assertSame('v_2', $actual->getAddressLine2());
        self::assertSame('v_3', $actual->getCity());
        self::assertSame('v_4', $actual->getCompanyName());
        self::assertSame('v_5', $actual->getCountry());
        self::assertSame('v_6', $actual->getEmail());
        self::assertSame('v_7', $actual->getPhone());
        self::assertSame('v_8', $actual->getPostalCode());
        self::assertSame('v_9', $actual->getStateOrProvince());
    }

    /**
     * @param array<string, mixed>                     $data
     * @param Closure(EconomicOperatorInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(EconomicOperatorInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (EconomicOperatorInterface $model): void {
                self::assertNull($model->getAddressLine1());
                self::assertNull($model->getAddressLine2());
                self::assertNull($model->getCity());
                self::assertNull($model->getCompanyName());
                self::assertNull($model->getCountry());
                self::assertNull($model->getEmail());
                self::assertNull($model->getPhone());
                self::assertNull($model->getPostalCode());
                self::assertNull($model->getStateOrProvince());
            },
        ];

        yield 'addressLine1WrongType' => [
            [...$base, EconomicOperatorTransformerInterface::KEY_ADDRESS_LINE1 => 42],
            static function (EconomicOperatorInterface $model): void {
                self::assertNull($model->getAddressLine1());
            },
        ];

        yield 'addressLine2WrongType' => [
            [...$base, EconomicOperatorTransformerInterface::KEY_ADDRESS_LINE2 => 42],
            static function (EconomicOperatorInterface $model): void {
                self::assertNull($model->getAddressLine2());
            },
        ];

        yield 'cityWrongType' => [
            [...$base, EconomicOperatorTransformerInterface::KEY_CITY => 42],
            static function (EconomicOperatorInterface $model): void {
                self::assertNull($model->getCity());
            },
        ];

        yield 'companyNameWrongType' => [
            [...$base, EconomicOperatorTransformerInterface::KEY_COMPANY_NAME => 42],
            static function (EconomicOperatorInterface $model): void {
                self::assertNull($model->getCompanyName());
            },
        ];

        yield 'countryWrongType' => [
            [...$base, EconomicOperatorTransformerInterface::KEY_COUNTRY => 42],
            static function (EconomicOperatorInterface $model): void {
                self::assertNull($model->getCountry());
            },
        ];

        yield 'emailWrongType' => [
            [...$base, EconomicOperatorTransformerInterface::KEY_EMAIL => 42],
            static function (EconomicOperatorInterface $model): void {
                self::assertNull($model->getEmail());
            },
        ];

        yield 'phoneWrongType' => [
            [...$base, EconomicOperatorTransformerInterface::KEY_PHONE => 42],
            static function (EconomicOperatorInterface $model): void {
                self::assertNull($model->getPhone());
            },
        ];

        yield 'postalCodeWrongType' => [
            [...$base, EconomicOperatorTransformerInterface::KEY_POSTAL_CODE => 42],
            static function (EconomicOperatorInterface $model): void {
                self::assertNull($model->getPostalCode());
            },
        ];

        yield 'stateOrProvinceWrongType' => [
            [...$base, EconomicOperatorTransformerInterface::KEY_STATE_OR_PROVINCE => 42],
            static function (EconomicOperatorInterface $model): void {
                self::assertNull($model->getStateOrProvince());
            },
        ];
    }

    private function buildTransformer(): EconomicOperatorTransformer
    {

        return new EconomicOperatorTransformer();
    }
}
