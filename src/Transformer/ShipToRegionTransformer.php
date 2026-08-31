<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ShipToRegion;
use ChristianBrown\EBay\Browse\Model\ShipToRegionInterface;

use function is_string;

final class ShipToRegionTransformer implements ShipToRegionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShipToRegionInterface
    {
        $shipToRegion = new ShipToRegion();

        self::applyRegionId($shipToRegion, $data);
        self::applyRegionName($shipToRegion, $data);
        self::applyRegionType($shipToRegion, $data);

        return $shipToRegion;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRegionId(ShipToRegion $shipToRegion, array $data): void
    {
        if (empty($data[self::KEY_REGION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_REGION_ID])) {
            return;
        }
        $shipToRegion->setRegionId($data[self::KEY_REGION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRegionName(ShipToRegion $shipToRegion, array $data): void
    {
        if (empty($data[self::KEY_REGION_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_REGION_NAME])) {
            return;
        }
        $shipToRegion->setRegionName($data[self::KEY_REGION_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRegionType(ShipToRegion $shipToRegion, array $data): void
    {
        if (empty($data[self::KEY_REGION_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_REGION_TYPE])) {
            return;
        }
        $shipToRegion->setRegionType($data[self::KEY_REGION_TYPE]);
    }
}
