<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\ShipToRegion;
use ChristianBrown\EBay\Browse\Model\ShipToRegionInterface;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ShipToRegion::class)]
#[CoversClass(ShipToRegionTransformer::class)]
final class ShipToRegionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ShipToRegionTransformerInterface::KEY_REGION_ID => 'v_0',
            ShipToRegionTransformerInterface::KEY_REGION_NAME => 'v_1',
            ShipToRegionTransformerInterface::KEY_REGION_TYPE => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getRegionId());
        self::assertSame('v_1', $actual->getRegionName());
        self::assertSame('v_2', $actual->getRegionType());
    }

    /**
     * @param array<string, mixed>                 $data
     * @param Closure(ShipToRegionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ShipToRegionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ShipToRegionInterface $model): void {
                self::assertNull($model->getRegionId());
                self::assertNull($model->getRegionName());
                self::assertNull($model->getRegionType());
            },
        ];

        yield 'regionIdWrongType' => [
            [...$base, ShipToRegionTransformerInterface::KEY_REGION_ID => 42],
            static function (ShipToRegionInterface $model): void {
                self::assertNull($model->getRegionId());
            },
        ];

        yield 'regionNameWrongType' => [
            [...$base, ShipToRegionTransformerInterface::KEY_REGION_NAME => 42],
            static function (ShipToRegionInterface $model): void {
                self::assertNull($model->getRegionName());
            },
        ];

        yield 'regionTypeWrongType' => [
            [...$base, ShipToRegionTransformerInterface::KEY_REGION_TYPE => 42],
            static function (ShipToRegionInterface $model): void {
                self::assertNull($model->getRegionType());
            },
        ];
    }

    private function buildTransformer(): ShipToRegionTransformer
    {
        return new ShipToRegionTransformer();
    }
}
