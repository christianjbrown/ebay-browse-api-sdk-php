<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ShipToRegionInterface;

interface ShipToRegionTransformerInterface
{
    public const string KEY_REGION_ID = 'regionId';
    public const string KEY_REGION_NAME = 'regionName';
    public const string KEY_REGION_TYPE = 'regionType';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShipToRegionInterface;
}
