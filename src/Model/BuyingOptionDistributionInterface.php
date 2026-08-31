<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface BuyingOptionDistributionInterface
{
    public function getBuyingOption(): ?string;

    public function getMatchCount(): ?int;

    public function getRefinementHref(): ?string;

    public function setBuyingOption(?string $value): self;

    public function setMatchCount(?int $value): self;

    public function setRefinementHref(?string $value): self;
}
