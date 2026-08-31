<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface AspectValueDistributionInterface
{
    public function getLocalizedAspectValue(): ?string;

    public function getMatchCount(): ?int;

    public function getRefinementHref(): ?string;

    public function setLocalizedAspectValue(?string $value): self;

    public function setMatchCount(?int $value): self;

    public function setRefinementHref(?string $value): self;
}
