<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ReviewRating;
use ChristianBrown\EBay\Browse\Model\ReviewRatingInterface;

use function is_array;
use function is_int;
use function is_string;

final class ReviewRatingTransformer implements ReviewRatingTransformerInterface
{
    private RatingHistogramsTransformerInterface $ratingHistogramsTransformer;

    public function __construct(RatingHistogramsTransformerInterface $ratingHistogramsTransformer)
    {
        $this->ratingHistogramsTransformer = $ratingHistogramsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ReviewRatingInterface
    {
        $reviewRating = new ReviewRating();

        self::applyAverageRating($reviewRating, $data);
        $this->applyRatingHistograms($reviewRating, $data);
        self::applyReviewCount($reviewRating, $data);

        return $reviewRating;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAverageRating(ReviewRating $reviewRating, array $data): void
    {
        if (empty($data[self::KEY_AVERAGE_RATING])) {
            return;
        }
        if (!is_string($data[self::KEY_AVERAGE_RATING])) {
            return;
        }
        $reviewRating->setAverageRating($data[self::KEY_AVERAGE_RATING]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRatingHistograms(ReviewRating $reviewRating, array $data): void
    {
        if (empty($data[self::KEY_RATING_HISTOGRAMS])) {
            return;
        }
        if (!is_array($data[self::KEY_RATING_HISTOGRAMS])) {
            return;
        }
        $reviewRating->setRatingHistograms($this->ratingHistogramsTransformer->transform($data[self::KEY_RATING_HISTOGRAMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyReviewCount(ReviewRating $reviewRating, array $data): void
    {
        if (!isset($data[self::KEY_REVIEW_COUNT])) {
            return;
        }
        if (!is_int($data[self::KEY_REVIEW_COUNT])) {
            return;
        }
        $reviewRating->setReviewCount($data[self::KEY_REVIEW_COUNT]);
    }
}
