<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ShipToLocations;
use ChristianBrown\EBay\Browse\Model\ShipToLocationsInterface;
use ChristianBrown\EBay\Browse\Model\ShipToRegionInterface;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionsTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShipToLocations::class)]
#[CoversClass(ShipToLocationsTransformer::class)]
final class ShipToLocationsTransformerTest extends TestCase
{
    private ?ShipToRegionInterface $shipToRegion = null;

    public function testTransform(): void
    {
        $data = [
            ShipToLocationsTransformerInterface::KEY_REGION_EXCLUDED => ['raw_regionExcluded'],
            ShipToLocationsTransformerInterface::KEY_REGION_INCLUDED => ['raw_regionIncluded'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame([$this->shipToRegion], $actual->getRegionExcluded());
        self::assertSame([$this->shipToRegion], $actual->getRegionIncluded());
    }

    /**
     * @param array<string, mixed>                    $data
     * @param Closure(ShipToLocationsInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ShipToLocationsInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ShipToLocationsInterface $model): void {
                self::assertSame([], $model->getRegionExcluded());
                self::assertSame([], $model->getRegionIncluded());
            },
        ];

        yield 'regionExcludedWrongType' => [
            [...$base, ShipToLocationsTransformerInterface::KEY_REGION_EXCLUDED => 'x'],
            static function (ShipToLocationsInterface $model): void {
                self::assertSame([], $model->getRegionExcluded());
            },
        ];

        yield 'regionIncludedWrongType' => [
            [...$base, ShipToLocationsTransformerInterface::KEY_REGION_INCLUDED => 'x'],
            static function (ShipToLocationsInterface $model): void {
                self::assertSame([], $model->getRegionIncluded());
            },
        ];
    }

    private function buildTransformer(): ShipToLocationsTransformer
    {
        $this->shipToRegion = self::createStub(ShipToRegionInterface::class);

        $shipToRegionsTransformer = self::createStub(ShipToRegionsTransformerInterface::class);
        $shipToRegionsTransformer->method('transform')->willReturn([$this->shipToRegion]);

        return new ShipToLocationsTransformer($shipToRegionsTransformer);
    }
}
