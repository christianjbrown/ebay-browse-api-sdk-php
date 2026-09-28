<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\RatingHistogramInterface;

interface RatingHistogramTransformerInterface
{
    public const string KEY_COUNT = 'count';
    public const string KEY_RATING = 'rating';
    public const string UNEXPECTED_INTEGER_SPRINTF = '%s not set or not an integer';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RatingHistogramInterface;
}
