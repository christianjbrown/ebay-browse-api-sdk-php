<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface RefinementInterface
{
    /**
     * @return array<int, AspectDistributionInterface>
     */
    public function getAspectDistributions(): array;

    /**
     * @return array<int, BuyingOptionDistributionInterface>
     */
    public function getBuyingOptionDistributions(): array;

    /**
     * @return array<int, CategoryDistributionInterface>
     */
    public function getCategoryDistributions(): array;

    /**
     * @return array<int, ConditionDistributionInterface>
     */
    public function getConditionDistributions(): array;

    public function getDominantCategoryId(): ?string;

    /**
     * @param array<int, AspectDistributionInterface> $value
     */
    public function setAspectDistributions(array $value): self;

    /**
     * @param array<int, BuyingOptionDistributionInterface> $value
     */
    public function setBuyingOptionDistributions(array $value): self;

    /**
     * @param array<int, CategoryDistributionInterface> $value
     */
    public function setCategoryDistributions(array $value): self;

    /**
     * @param array<int, ConditionDistributionInterface> $value
     */
    public function setConditionDistributions(array $value): self;

    public function setDominantCategoryId(?string $value): self;
}
