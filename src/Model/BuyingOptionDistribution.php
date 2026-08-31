<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class BuyingOptionDistribution implements BuyingOptionDistributionInterface
{
    private ?string $buyingOption = null;
    private ?int $matchCount = null;
    private ?string $refinementHref = null;

    public function getBuyingOption(): ?string
    {
        return $this->buyingOption;
    }

    public function getMatchCount(): ?int
    {
        return $this->matchCount;
    }

    public function getRefinementHref(): ?string
    {
        return $this->refinementHref;
    }

    public function setBuyingOption(?string $value): BuyingOptionDistributionInterface
    {
        $this->buyingOption = $value;

        return $this;
    }

    public function setMatchCount(?int $value): BuyingOptionDistributionInterface
    {
        $this->matchCount = $value;

        return $this;
    }

    public function setRefinementHref(?string $value): BuyingOptionDistributionInterface
    {
        $this->refinementHref = $value;

        return $this;
    }
}
