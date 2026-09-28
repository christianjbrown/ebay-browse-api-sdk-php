<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\RegionInterface;
use ChristianBrown\EBay\Browse\Model\TaxJurisdiction;
use ChristianBrown\EBay\Browse\Model\TaxJurisdictionInterface;
use ChristianBrown\EBay\Browse\Transformer\RegionTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TaxJurisdictionTransformer;
use ChristianBrown\EBay\Browse\Transformer\TaxJurisdictionTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(TaxJurisdiction::class)]
#[CoversClass(TaxJurisdictionTransformer::class)]
final class TaxJurisdictionTransformerTest extends TestCase
{
    private ?RegionInterface $region = null;

    public function testTransform(): void
    {
        $data = [
            TaxJurisdictionTransformerInterface::KEY_REGION => ['raw_region'],
            TaxJurisdictionTransformerInterface::KEY_TAX_JURISDICTION_ID => 'v_1',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($this->region, $actual->getRegion());
        self::assertSame('v_1', $actual->getTaxJurisdictionId());
    }

    /**
     * @param array<string, mixed>                    $data
     * @param Closure(TaxJurisdictionInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(TaxJurisdictionInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (TaxJurisdictionInterface $model): void {
                self::assertNull($model->getRegion());
                self::assertNull($model->getTaxJurisdictionId());
            },
        ];

        yield 'regionWrongType' => [
            [...$base, TaxJurisdictionTransformerInterface::KEY_REGION => 'x'],
            static function (TaxJurisdictionInterface $model): void {
                self::assertNull($model->getRegion());
            },
        ];

        yield 'taxJurisdictionIdWrongType' => [
            [...$base, TaxJurisdictionTransformerInterface::KEY_TAX_JURISDICTION_ID => 42],
            static function (TaxJurisdictionInterface $model): void {
                self::assertNull($model->getTaxJurisdictionId());
            },
        ];
    }

    private function buildTransformer(): TaxJurisdictionTransformer
    {
        $this->region = self::createStub(RegionInterface::class);

        $regionTransformer = self::createStub(RegionTransformerInterface::class);
        $regionTransformer->method('transform')->willReturn($this->region);

        return new TaxJurisdictionTransformer($regionTransformer);
    }
}
