<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\RatingHistogram;
use ChristianBrown\EBay\Browse\Model\RatingHistogramInterface;
use ChristianBrown\EBay\Browse\Transformer\RatingHistogramTransformer;
use ChristianBrown\EBay\Browse\Transformer\RatingHistogramTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(RatingHistogram::class)]
#[CoversClass(RatingHistogramTransformer::class)]
final class RatingHistogramTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            RatingHistogramTransformerInterface::KEY_COUNT => 101,
            RatingHistogramTransformerInterface::KEY_RATING => 'v_2',
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame(101, $actual->getCount());
        self::assertSame('v_2', $actual->getRating());
    }

    /**
     * @param array<string, mixed>                    $data
     * @param Closure(RatingHistogramInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(RatingHistogramInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (RatingHistogramInterface $model): void {
                self::assertNull($model->getCount());
                self::assertNull($model->getRating());
            },
        ];

        yield 'countWrongType' => [
            [...$base, RatingHistogramTransformerInterface::KEY_COUNT => 'x'],
            static function (RatingHistogramInterface $model): void {
                self::assertNull($model->getCount());
            },
        ];

        yield 'countZero' => [
            [...$base, RatingHistogramTransformerInterface::KEY_COUNT => 0],
            static function (RatingHistogramInterface $model): void {
                self::assertSame(0, $model->getCount());
            },
        ];

        yield 'ratingWrongType' => [
            [...$base, RatingHistogramTransformerInterface::KEY_RATING => 42],
            static function (RatingHistogramInterface $model): void {
                self::assertNull($model->getRating());
            },
        ];
    }

    private function buildTransformer(): RatingHistogramTransformer
    {

        return new RatingHistogramTransformer();
    }
}
