<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ShipToRegionInterface;

interface ShipToRegionsTransformerInterface
{
    public const string ARRAY_NAME = 'shipToRegion';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, ShipToRegionInterface>
     */
    public function transform(array $data): array;
}
