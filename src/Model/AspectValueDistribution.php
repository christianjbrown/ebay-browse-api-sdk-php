<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class AspectValueDistribution implements AspectValueDistributionInterface
{
    private ?string $localizedAspectValue = null;
    private ?int $matchCount = null;
    private ?string $refinementHref = null;

    public function getLocalizedAspectValue(): ?string
    {
        return $this->localizedAspectValue;
    }

    public function getMatchCount(): ?int
    {
        return $this->matchCount;
    }

    public function getRefinementHref(): ?string
    {
        return $this->refinementHref;
    }

    public function setLocalizedAspectValue(?string $value): AspectValueDistributionInterface
    {
        $this->localizedAspectValue = $value;

        return $this;
    }

    public function setMatchCount(?int $value): AspectValueDistributionInterface
    {
        $this->matchCount = $value;

        return $this;
    }

    public function setRefinementHref(?string $value): AspectValueDistributionInterface
    {
        $this->refinementHref = $value;

        return $this;
    }
}
