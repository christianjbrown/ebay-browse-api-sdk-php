<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ReviewRatingInterface;

interface ReviewRatingTransformerInterface
{
    public const string KEY_AVERAGE_RATING = 'averageRating';
    public const string KEY_RATING_HISTOGRAMS = 'ratingHistograms';
    public const string KEY_REVIEW_COUNT = 'reviewCount';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_INTEGER_SPRINTF = '%s not set or not an integer';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ReviewRatingInterface;
}
