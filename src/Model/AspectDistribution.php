<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class AspectDistribution implements AspectDistributionInterface
{
    /**
     * @var array<int, AspectValueDistributionInterface>
     */
    private array $aspectValueDistributions = [];
    private ?string $localizedAspectName = null;

    /**
     * @return array<int, AspectValueDistributionInterface>
     */
    public function getAspectValueDistributions(): array
    {
        return $this->aspectValueDistributions;
    }

    public function getLocalizedAspectName(): ?string
    {
        return $this->localizedAspectName;
    }

    /**
     * @param array<int, AspectValueDistributionInterface> $value
     */
    public function setAspectValueDistributions(array $value): AspectDistributionInterface
    {
        $this->aspectValueDistributions = $value;

        return $this;
    }

    public function setLocalizedAspectName(?string $value): AspectDistributionInterface
    {
        $this->localizedAspectName = $value;

        return $this;
    }
}
