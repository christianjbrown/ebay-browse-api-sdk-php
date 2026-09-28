<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface PickupOptionSummaryInterface
{
    public function getPickupLocationType(): ?string;

    public function setPickupLocationType(?string $value): self;
}
