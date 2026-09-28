<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class PickupOptionSummary implements PickupOptionSummaryInterface
{
    private ?string $pickupLocationType = null;

    public function getPickupLocationType(): ?string
    {
        return $this->pickupLocationType;
    }

    public function setPickupLocationType(?string $value): PickupOptionSummaryInterface
    {
        $this->pickupLocationType = $value;

        return $this;
    }
}
