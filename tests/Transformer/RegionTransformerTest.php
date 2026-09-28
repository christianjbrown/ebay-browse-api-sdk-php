<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\Region;
use ChristianBrown\EBay\Browse\Model\RegionInterface;
use ChristianBrown\EBay\Browse\Transformer\RegionTransformer;
use ChristianBrown\EBay\Browse\Transformer\RegionTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Region::class)]
#[CoversClass(RegionTransformer::class)]
final class RegionTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            RegionTransformerInterface::KEY_REGION_NAME => 'v_1',
            RegionTransformerInterface::KEY_REGION_TYPE => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getRegionName());
        self::assertSame('v_2', $actual->getRegionType());
    }

    /**
     * @param array<string, mixed>           $data
     * @param Closure(RegionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(RegionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (RegionInterface $model): void {
                self::assertNull($model->getRegionName());
                self::assertNull($model->getRegionType());
            },
        ];

        yield 'regionNameWrongType' => [
            [...$base, RegionTransformerInterface::KEY_REGION_NAME => 42],
            static function (RegionInterface $model): void {
                self::assertNull($model->getRegionName());
            },
        ];

        yield 'regionTypeWrongType' => [
            [...$base, RegionTransformerInterface::KEY_REGION_TYPE => 42],
            static function (RegionInterface $model): void {
                self::assertNull($model->getRegionType());
            },
        ];
    }

    private function buildTransformer(): RegionTransformer
    {

        return new RegionTransformer();
    }
}
