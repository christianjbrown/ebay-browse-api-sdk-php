<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface RatingHistogramInterface
{
    public function getCount(): ?int;

    public function getRating(): ?string;

    public function setCount(?int $value): self;

    public function setRating(?string $value): self;
}
