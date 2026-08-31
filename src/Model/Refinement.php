<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class Refinement implements RefinementInterface
{
    /**
     * @var array<int, AspectDistributionInterface>
     */
    private array $aspectDistributions = [];

    /**
     * @var array<int, BuyingOptionDistributionInterface>
     */
    private array $buyingOptionDistributions = [];

    /**
     * @var array<int, CategoryDistributionInterface>
     */
    private array $categoryDistributions = [];

    /**
     * @var array<int, ConditionDistributionInterface>
     */
    private array $conditionDistributions = [];
    private ?string $dominantCategoryId = null;

    /**
     * @return array<int, AspectDistributionInterface>
     */
    public function getAspectDistributions(): array
    {
        return $this->aspectDistributions;
    }

    /**
     * @return array<int, BuyingOptionDistributionInterface>
     */
    public function getBuyingOptionDistributions(): array
    {
        return $this->buyingOptionDistributions;
    }

    /**
     * @return array<int, CategoryDistributionInterface>
     */
    public function getCategoryDistributions(): array
    {
        return $this->categoryDistributions;
    }

    /**
     * @return array<int, ConditionDistributionInterface>
     */
    public function getConditionDistributions(): array
    {
        return $this->conditionDistributions;
    }

    public function getDominantCategoryId(): ?string
    {
        return $this->dominantCategoryId;
    }

    /**
     * @param array<int, AspectDistributionInterface> $value
     */
    public function setAspectDistributions(array $value): RefinementInterface
    {
        $this->aspectDistributions = $value;

        return $this;
    }

    /**
     * @param array<int, BuyingOptionDistributionInterface> $value
     */
    public function setBuyingOptionDistributions(array $value): RefinementInterface
    {
        $this->buyingOptionDistributions = $value;

        return $this;
    }

    /**
     * @param array<int, CategoryDistributionInterface> $value
     */
    public function setCategoryDistributions(array $value): RefinementInterface
    {
        $this->categoryDistributions = $value;

        return $this;
    }

    /**
     * @param array<int, ConditionDistributionInterface> $value
     */
    public function setConditionDistributions(array $value): RefinementInterface
    {
        $this->conditionDistributions = $value;

        return $this;
    }

    public function setDominantCategoryId(?string $value): RefinementInterface
    {
        $this->dominantCategoryId = $value;

        return $this;
    }
}
