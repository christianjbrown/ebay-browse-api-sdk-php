<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Region;
use ChristianBrown\EBay\Browse\Model\RegionInterface;

use function is_string;

final class RegionTransformer implements RegionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RegionInterface
    {
        $region = new Region();

        self::applyRegionName($region, $data);
        self::applyRegionType($region, $data);

        return $region;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRegionName(Region $region, array $data): void
    {
        if (empty($data[self::KEY_REGION_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_REGION_NAME])) {
            return;
        }
        $region->setRegionName($data[self::KEY_REGION_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRegionType(Region $region, array $data): void
    {
        if (empty($data[self::KEY_REGION_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_REGION_TYPE])) {
            return;
        }
        $region->setRegionType($data[self::KEY_REGION_TYPE]);
    }
}
