<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class RatingHistogram implements RatingHistogramInterface
{
    private ?int $count = null;
    private ?string $rating = null;

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setCount(?int $value): RatingHistogramInterface
    {
        $this->count = $value;

        return $this;
    }

    public function setRating(?string $value): RatingHistogramInterface
    {
        $this->rating = $value;

        return $this;
    }
}
