<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\HazardPictogram;
use ChristianBrown\EBay\Browse\Model\HazardPictogramInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardPictogramTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardPictogramTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(HazardPictogram::class)]
#[CoversClass(HazardPictogramTransformer::class)]
final class HazardPictogramTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            HazardPictogramTransformerInterface::KEY_PICTOGRAM_DESCRIPTION => 'v_1',
            HazardPictogramTransformerInterface::KEY_PICTOGRAM_ID => 'v_2',
            HazardPictogramTransformerInterface::KEY_PICTOGRAM_URL => 'v_3',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getPictogramDescription());
        self::assertSame('v_2', $actual->getPictogramId());
        self::assertSame('v_3', $actual->getPictogramUrl());
    }

    /**
     * @param array<string, mixed>                    $data
     * @param Closure(HazardPictogramInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(HazardPictogramInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (HazardPictogramInterface $model): void {
                self::assertNull($model->getPictogramDescription());
                self::assertNull($model->getPictogramId());
                self::assertNull($model->getPictogramUrl());
            },
        ];

        yield 'pictogramDescriptionWrongType' => [
            [...$base, HazardPictogramTransformerInterface::KEY_PICTOGRAM_DESCRIPTION => 42],
            static function (HazardPictogramInterface $model): void {
                self::assertNull($model->getPictogramDescription());
            },
        ];

        yield 'pictogramIdWrongType' => [
            [...$base, HazardPictogramTransformerInterface::KEY_PICTOGRAM_ID => 42],
            static function (HazardPictogramInterface $model): void {
                self::assertNull($model->getPictogramId());
            },
        ];

        yield 'pictogramUrlWrongType' => [
            [...$base, HazardPictogramTransformerInterface::KEY_PICTOGRAM_URL => 42],
            static function (HazardPictogramInterface $model): void {
                self::assertNull($model->getPictogramUrl());
            },
        ];
    }

    private function buildTransformer(): HazardPictogramTransformer
    {

        return new HazardPictogramTransformer();
    }
}
