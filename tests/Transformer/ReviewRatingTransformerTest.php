<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Model\RatingHistogramInterface;
use ChristianBrown\EBay\Browse\Model\ReviewRating;
use ChristianBrown\EBay\Browse\Model\ReviewRatingInterface;
use ChristianBrown\EBay\Browse\Transformer\RatingHistogramsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ReviewRatingTransformer;
use ChristianBrown\EBay\Browse\Transformer\ReviewRatingTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReviewRating::class)]
#[CoversClass(ReviewRatingTransformer::class)]
final class ReviewRatingTransformerTest extends TestCase
{
    private ?RatingHistogramInterface $ratingHistogram = null;

    public function testTransform(): void
    {
        $data = [
            ReviewRatingTransformerInterface::KEY_AVERAGE_RATING => 'v_1',
            ReviewRatingTransformerInterface::KEY_RATING_HISTOGRAMS => ['raw_ratingHistograms'],
            ReviewRatingTransformerInterface::KEY_REVIEW_COUNT => 102,
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_1', $actual->getAverageRating());
        self::assertSame([$this->ratingHistogram], $actual->getRatingHistograms());
        self::assertSame(102, $actual->getReviewCount());
    }

    /**
     * @param array<string, mixed>                 $data
     * @param Closure(ReviewRatingInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ReviewRatingInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ReviewRatingInterface $model): void {
                self::assertNull($model->getAverageRating());
                self::assertSame([], $model->getRatingHistograms());
                self::assertNull($model->getReviewCount());
            },
        ];

        yield 'averageRatingWrongType' => [
            [...$base, ReviewRatingTransformerInterface::KEY_AVERAGE_RATING => 42],
            static function (ReviewRatingInterface $model): void {
                self::assertNull($model->getAverageRating());
            },
        ];

        yield 'ratingHistogramsWrongType' => [
            [...$base, ReviewRatingTransformerInterface::KEY_RATING_HISTOGRAMS => 'x'],
            static function (ReviewRatingInterface $model): void {
                self::assertSame([], $model->getRatingHistograms());
            },
        ];

        yield 'reviewCountWrongType' => [
            [...$base, ReviewRatingTransformerInterface::KEY_REVIEW_COUNT => 'x'],
            static function (ReviewRatingInterface $model): void {
                self::assertNull($model->getReviewCount());
            },
        ];

        yield 'reviewCountZero' => [
            [...$base, ReviewRatingTransformerInterface::KEY_REVIEW_COUNT => 0],
            static function (ReviewRatingInterface $model): void {
                self::assertSame(0, $model->getReviewCount());
            },
        ];
    }

    private function buildTransformer(): ReviewRatingTransformer
    {
        $this->ratingHistogram = self::createStub(RatingHistogramInterface::class);

        $ratingHistogramsTransformer = self::createStub(RatingHistogramsTransformerInterface::class);
        $ratingHistogramsTransformer->method('transform')->willReturn([$this->ratingHistogram]);

        return new ReviewRatingTransformer($ratingHistogramsTransformer);
    }
}
