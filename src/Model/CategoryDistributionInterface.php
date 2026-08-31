<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface CategoryDistributionInterface
{
    public function getCategoryId(): ?string;

    public function getCategoryName(): ?string;

    public function getMatchCount(): ?int;

    public function getRefinementHref(): ?string;

    public function setCategoryId(?string $value): self;

    public function setCategoryName(?string $value): self;

    public function setMatchCount(?int $value): self;

    public function setRefinementHref(?string $value): self;
}
