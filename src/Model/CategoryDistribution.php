<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class CategoryDistribution implements CategoryDistributionInterface
{
    private ?string $categoryId = null;
    private ?string $categoryName = null;
    private ?int $matchCount = null;
    private ?string $refinementHref = null;

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function getMatchCount(): ?int
    {
        return $this->matchCount;
    }

    public function getRefinementHref(): ?string
    {
        return $this->refinementHref;
    }

    public function setCategoryId(?string $value): CategoryDistributionInterface
    {
        $this->categoryId = $value;

        return $this;
    }

    public function setCategoryName(?string $value): CategoryDistributionInterface
    {
        $this->categoryName = $value;

        return $this;
    }

    public function setMatchCount(?int $value): CategoryDistributionInterface
    {
        $this->matchCount = $value;

        return $this;
    }

    public function setRefinementHref(?string $value): CategoryDistributionInterface
    {
        $this->refinementHref = $value;

        return $this;
    }
}
