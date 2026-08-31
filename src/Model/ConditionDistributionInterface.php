<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ConditionDistributionInterface
{
    public function getCondition(): ?string;

    public function getConditionId(): ?string;

    public function getMatchCount(): ?int;

    public function getRefinementHref(): ?string;

    public function setCondition(?string $value): self;

    public function setConditionId(?string $value): self;

    public function setMatchCount(?int $value): self;

    public function setRefinementHref(?string $value): self;
}
