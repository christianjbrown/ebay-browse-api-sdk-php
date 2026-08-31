<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ShipToLocations;
use ChristianBrown\EBay\Browse\Model\ShipToLocationsInterface;

use function is_array;

final class ShipToLocationsTransformer implements ShipToLocationsTransformerInterface
{
    private ShipToRegionsTransformerInterface $shipToRegionsTransformer;

    public function __construct(ShipToRegionsTransformerInterface $shipToRegionsTransformer)
    {
        $this->shipToRegionsTransformer = $shipToRegionsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShipToLocationsInterface
    {
        $shipToLocations = new ShipToLocations();

        $this->applyRegionExcluded($shipToLocations, $data);
        $this->applyRegionIncluded($shipToLocations, $data);

        return $shipToLocations;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRegionExcluded(ShipToLocations $shipToLocations, array $data): void
    {
        if (empty($data[self::KEY_REGION_EXCLUDED])) {
            return;
        }
        if (!is_array($data[self::KEY_REGION_EXCLUDED])) {
            return;
        }
        $shipToLocations->setRegionExcluded($this->shipToRegionsTransformer->transform($data[self::KEY_REGION_EXCLUDED]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRegionIncluded(ShipToLocations $shipToLocations, array $data): void
    {
        if (empty($data[self::KEY_REGION_INCLUDED])) {
            return;
        }
        if (!is_array($data[self::KEY_REGION_INCLUDED])) {
            return;
        }
        $shipToLocations->setRegionIncluded($this->shipToRegionsTransformer->transform($data[self::KEY_REGION_INCLUDED]));
    }
}
