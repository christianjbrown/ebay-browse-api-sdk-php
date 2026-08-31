<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ItemLocation;
use ChristianBrown\EBay\Browse\Model\ItemLocationInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ItemLocation::class)]
#[CoversClass(ItemLocationTransformer::class)]
final class ItemLocationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ItemLocationTransformerInterface::KEY_COUNTRY => 'v_0',
            ItemLocationTransformerInterface::KEY_ADDRESS_LINE_1 => 'v_1',
            ItemLocationTransformerInterface::KEY_ADDRESS_LINE_2 => 'v_2',
            ItemLocationTransformerInterface::KEY_CITY => 'v_3',
            ItemLocationTransformerInterface::KEY_COUNTY => 'v_4',
            ItemLocationTransformerInterface::KEY_POSTAL_CODE => 'v_5',
            ItemLocationTransformerInterface::KEY_STATE_OR_PROVINCE => 'v_6',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getCountry());
        self::assertSame('v_1', $actual->getAddressLine1());
        self::assertSame('v_2', $actual->getAddressLine2());
        self::assertSame('v_3', $actual->getCity());
        self::assertSame('v_4', $actual->getCounty());
        self::assertSame('v_5', $actual->getPostalCode());
        self::assertSame('v_6', $actual->getStateOrProvince());
    }

    /**
     * @param array<string, mixed>                 $data
     * @param Closure(ItemLocationInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ItemLocationInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [ItemLocationTransformerInterface::KEY_COUNTRY => 'v_0'];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ItemLocationInterface $model): void {
                self::assertNull($model->getAddressLine1());
                self::assertNull($model->getAddressLine2());
                self::assertNull($model->getCity());
                self::assertNull($model->getCounty());
                self::assertNull($model->getPostalCode());
                self::assertNull($model->getStateOrProvince());
            },
        ];

        yield 'addressLine1WrongType' => [
            [...$base, ItemLocationTransformerInterface::KEY_ADDRESS_LINE_1 => 42],
            static function (ItemLocationInterface $model): void {
                self::assertNull($model->getAddressLine1());
            },
        ];

        yield 'addressLine2WrongType' => [
            [...$base, ItemLocationTransformerInterface::KEY_ADDRESS_LINE_2 => 42],
            static function (ItemLocationInterface $model): void {
                self::assertNull($model->getAddressLine2());
            },
        ];

        yield 'cityWrongType' => [
            [...$base, ItemLocationTransformerInterface::KEY_CITY => 42],
            static function (ItemLocationInterface $model): void {
                self::assertNull($model->getCity());
            },
        ];

        yield 'countyWrongType' => [
            [...$base, ItemLocationTransformerInterface::KEY_COUNTY => 42],
            static function (ItemLocationInterface $model): void {
                self::assertNull($model->getCounty());
            },
        ];

        yield 'postalCodeWrongType' => [
            [...$base, ItemLocationTransformerInterface::KEY_POSTAL_CODE => 42],
            static function (ItemLocationInterface $model): void {
                self::assertNull($model->getPostalCode());
            },
        ];

        yield 'stateOrProvinceWrongType' => [
            [...$base, ItemLocationTransformerInterface::KEY_STATE_OR_PROVINCE => 42],
            static function (ItemLocationInterface $model): void {
                self::assertNull($model->getStateOrProvince());
            },
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ItemLocationTransformerInterface::KEY_COUNTRY => 42]])]
    public function testTransformThrowsOnInvalidCountry(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ItemLocationTransformerInterface::UNEXPECTED_STRING_SPRINTF, ItemLocationTransformerInterface::KEY_COUNTRY));

        $transformer->transform($data);
    }

    private function buildTransformer(): ItemLocationTransformer
    {
        return new ItemLocationTransformer();
    }
}
