<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Model;

use ChristianBrown\EBay\Browse\Model\RatingHistogram;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RatingHistogram::class)]
final class RatingHistogramTest extends TestCase
{
    public function test(): void
    {
        $ratingHistogram = new RatingHistogram();
        self::assertNull($ratingHistogram->getCount());
        self::assertNull($ratingHistogram->getRating());

        self::assertSame($ratingHistogram, $ratingHistogram->setCount(42));
        self::assertSame($ratingHistogram, $ratingHistogram->setRating('val_rating'));

        self::assertSame(42, $ratingHistogram->getCount());
        self::assertSame('val_rating', $ratingHistogram->getRating());
    }
}
