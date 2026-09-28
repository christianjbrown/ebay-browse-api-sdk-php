<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\PickupOptionSummaryInterface;

interface PickupOptionSummaryTransformerInterface
{
    public const string KEY_PICKUP_LOCATION_TYPE = 'pickupLocationType';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PickupOptionSummaryInterface;
}
