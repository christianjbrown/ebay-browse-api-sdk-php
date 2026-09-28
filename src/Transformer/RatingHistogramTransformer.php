<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\RatingHistogram;
use ChristianBrown\EBay\Browse\Model\RatingHistogramInterface;

use function is_int;
use function is_string;

final class RatingHistogramTransformer implements RatingHistogramTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RatingHistogramInterface
    {
        $ratingHistogram = new RatingHistogram();

        self::applyCount($ratingHistogram, $data);
        self::applyRating($ratingHistogram, $data);

        return $ratingHistogram;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCount(RatingHistogram $ratingHistogram, array $data): void
    {
        if (!isset($data[self::KEY_COUNT])) {
            return;
        }
        if (!is_int($data[self::KEY_COUNT])) {
            return;
        }
        $ratingHistogram->setCount($data[self::KEY_COUNT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRating(RatingHistogram $ratingHistogram, array $data): void
    {
        if (empty($data[self::KEY_RATING])) {
            return;
        }
        if (!is_string($data[self::KEY_RATING])) {
            return;
        }
        $ratingHistogram->setRating($data[self::KEY_RATING]);
    }
}
