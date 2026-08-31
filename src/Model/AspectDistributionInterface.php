<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface AspectDistributionInterface
{
    /**
     * @return array<int, AspectValueDistributionInterface>
     */
    public function getAspectValueDistributions(): array;

    public function getLocalizedAspectName(): ?string;

    /**
     * @param array<int, AspectValueDistributionInterface> $value
     */
    public function setAspectValueDistributions(array $value): self;

    public function setLocalizedAspectName(?string $value): self;
}
