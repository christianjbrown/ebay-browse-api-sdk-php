<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class Region implements RegionInterface
{
    private ?string $regionName = null;
    private ?string $regionType = null;

    public function getRegionName(): ?string
    {
        return $this->regionName;
    }

    public function getRegionType(): ?string
    {
        return $this->regionType;
    }

    public function setRegionName(?string $value): RegionInterface
    {
        $this->regionName = $value;

        return $this;
    }

    public function setRegionType(?string $value): RegionInterface
    {
        $this->regionType = $value;

        return $this;
    }
}
