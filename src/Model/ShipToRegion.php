<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ShipToRegion implements ShipToRegionInterface
{
    private ?string $regionId = null;
    private ?string $regionName = null;
    private ?string $regionType = null;

    public function getRegionId(): ?string
    {
        return $this->regionId;
    }

    public function getRegionName(): ?string
    {
        return $this->regionName;
    }

    public function getRegionType(): ?string
    {
        return $this->regionType;
    }

    public function setRegionId(?string $value): ShipToRegionInterface
    {
        $this->regionId = $value;

        return $this;
    }

    public function setRegionName(?string $value): ShipToRegionInterface
    {
        $this->regionName = $value;

        return $this;
    }

    public function setRegionType(?string $value): ShipToRegionInterface
    {
        $this->regionType = $value;

        return $this;
    }
}
