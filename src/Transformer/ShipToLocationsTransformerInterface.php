<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ShipToLocationsInterface;

interface ShipToLocationsTransformerInterface
{
    public const string KEY_REGION_EXCLUDED = 'regionExcluded';
    public const string KEY_REGION_INCLUDED = 'regionIncluded';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShipToLocationsInterface;
}
