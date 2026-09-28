<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ReviewRating implements ReviewRatingInterface
{
    private ?string $averageRating = null;

    /**
     * @var array<int, RatingHistogramInterface>
     */
    private array $ratingHistograms = [];
    private ?int $reviewCount = null;

    public function getAverageRating(): ?string
    {
        return $this->averageRating;
    }

    /**
     * @return array<int, RatingHistogramInterface>
     */
    public function getRatingHistograms(): array
    {
        return $this->ratingHistograms;
    }

    public function getReviewCount(): ?int
    {
        return $this->reviewCount;
    }

    public function setAverageRating(?string $value): ReviewRatingInterface
    {
        $this->averageRating = $value;

        return $this;
    }

    /**
     * @param array<int, RatingHistogramInterface> $value
     */
    public function setRatingHistograms(array $value): ReviewRatingInterface
    {
        $this->ratingHistograms = $value;

        return $this;
    }

    public function setReviewCount(?int $value): ReviewRatingInterface
    {
        $this->reviewCount = $value;

        return $this;
    }
}
