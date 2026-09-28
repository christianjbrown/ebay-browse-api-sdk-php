<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ShipToLocation;
use ChristianBrown\EBay\Browse\Model\ShipToLocationInterface;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShipToLocation::class)]
#[CoversClass(ShipToLocationTransformer::class)]
final class ShipToLocationTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ShipToLocationTransformerInterface::KEY_COUNTRY => 'v_1',
            ShipToLocationTransformerInterface::KEY_POSTAL_CODE => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getCountry());
        self::assertSame('v_2', $actual->getPostalCode());
    }

    /**
     * @param array<string, mixed>                   $data
     * @param Closure(ShipToLocationInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ShipToLocationInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ShipToLocationInterface $model): void {
                self::assertNull($model->getCountry());
                self::assertNull($model->getPostalCode());
            },
        ];

        yield 'countryWrongType' => [
            [...$base, ShipToLocationTransformerInterface::KEY_COUNTRY => 42],
            static function (ShipToLocationInterface $model): void {
                self::assertNull($model->getCountry());
            },
        ];

        yield 'postalCodeWrongType' => [
            [...$base, ShipToLocationTransformerInterface::KEY_POSTAL_CODE => 42],
            static function (ShipToLocationInterface $model): void {
                self::assertNull($model->getPostalCode());
            },
        ];
    }

    private function buildTransformer(): ShipToLocationTransformer
    {

        return new ShipToLocationTransformer();
    }
}
