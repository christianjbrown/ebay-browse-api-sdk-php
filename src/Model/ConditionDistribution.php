<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ConditionDistribution implements ConditionDistributionInterface
{
    private ?string $condition = null;
    private ?string $conditionId = null;
    private ?int $matchCount = null;
    private ?string $refinementHref = null;

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function getConditionId(): ?string
    {
        return $this->conditionId;
    }

    public function getMatchCount(): ?int
    {
        return $this->matchCount;
    }

    public function getRefinementHref(): ?string
    {
        return $this->refinementHref;
    }

    public function setCondition(?string $value): ConditionDistributionInterface
    {
        $this->condition = $value;

        return $this;
    }

    public function setConditionId(?string $value): ConditionDistributionInterface
    {
        $this->conditionId = $value;

        return $this;
    }

    public function setMatchCount(?int $value): ConditionDistributionInterface
    {
        $this->matchCount = $value;

        return $this;
    }

    public function setRefinementHref(?string $value): ConditionDistributionInterface
    {
        $this->refinementHref = $value;

        return $this;
    }
}
