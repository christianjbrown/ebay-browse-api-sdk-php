<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ShipToLocations implements ShipToLocationsInterface
{
    /**
     * @var array<int, ShipToRegionInterface>
     */
    private array $regionExcluded = [];

    /**
     * @var array<int, ShipToRegionInterface>
     */
    private array $regionIncluded = [];

    /**
     * @return array<int, ShipToRegionInterface>
     */
    public function getRegionExcluded(): array
    {
        return $this->regionExcluded;
    }

    /**
     * @return array<int, ShipToRegionInterface>
     */
    public function getRegionIncluded(): array
    {
        return $this->regionIncluded;
    }

    /**
     * @param array<int, ShipToRegionInterface> $value
     */
    public function setRegionExcluded(array $value): ShipToLocationsInterface
    {
        $this->regionExcluded = $value;

        return $this;
    }

    /**
     * @param array<int, ShipToRegionInterface> $value
     */
    public function setRegionIncluded(array $value): ShipToLocationsInterface
    {
        $this->regionIncluded = $value;

        return $this;
    }
}
