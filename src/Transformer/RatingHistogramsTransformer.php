<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\RatingHistogramInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class RatingHistogramsTransformer implements RatingHistogramsTransformerInterface
{
    private RatingHistogramTransformerInterface $ratingHistogramTransformer;

    public function __construct(RatingHistogramTransformerInterface $ratingHistogramTransformer)
    {
        $this->ratingHistogramTransformer = $ratingHistogramTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, RatingHistogramInterface>
     */
    public function transform(array $data): array
    {
        $ratingHistograms = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $ratingHistogramData = $values[$i];
            if (!is_array($ratingHistogramData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $ratingHistograms[] = $this->ratingHistogramTransformer->transform($ratingHistogramData);
        }

        return $ratingHistograms;
    }
}
