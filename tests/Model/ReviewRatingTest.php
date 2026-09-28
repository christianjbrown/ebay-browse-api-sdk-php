<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\RatingHistogramInterface;
use ChristianBrown\EBay\Browse\Model\ReviewRating;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReviewRating::class)]
final class ReviewRatingTest extends TestCase
{
    public function test(): void
    {
        $ratingHistograms = [self::createStub(RatingHistogramInterface::class)];

        $reviewRating = new ReviewRating();
        self::assertNull($reviewRating->getAverageRating());
        self::assertSame([], $reviewRating->getRatingHistograms());
        self::assertNull($reviewRating->getReviewCount());

        self::assertSame($reviewRating, $reviewRating->setAverageRating('val_averageRating'));
        self::assertSame($reviewRating, $reviewRating->setRatingHistograms($ratingHistograms));
        self::assertSame($reviewRating, $reviewRating->setReviewCount(42));

        self::assertSame('val_averageRating', $reviewRating->getAverageRating());
        self::assertSame($ratingHistograms, $reviewRating->getRatingHistograms());
        self::assertSame(42, $reviewRating->getReviewCount());
    }
}
