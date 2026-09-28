<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ReviewRatingInterface
{
    public function getAverageRating(): ?string;

    /**
     * @return array<int, RatingHistogramInterface>
     */
    public function getRatingHistograms(): array;

    public function getReviewCount(): ?int;

    public function setAverageRating(?string $value): self;

    /**
     * @param array<int, RatingHistogramInterface> $value
     */
    public function setRatingHistograms(array $value): self;

    public function setReviewCount(?int $value): self;
}
