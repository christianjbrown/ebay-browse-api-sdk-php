<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ShipToLocationsInterface
{
    /**
     * @return array<int, ShipToRegionInterface>
     */
    public function getRegionExcluded(): array;

    /**
     * @return array<int, ShipToRegionInterface>
     */
    public function getRegionIncluded(): array;

    /**
     * @param array<int, ShipToRegionInterface> $value
     */
    public function setRegionExcluded(array $value): self;

    /**
     * @param array<int, ShipToRegionInterface> $value
     */
    public function setRegionIncluded(array $value): self;
}
