<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\PickupOptionSummary;
use ChristianBrown\EBay\Browse\Model\PickupOptionSummaryInterface;

use function is_string;

final class PickupOptionSummaryTransformer implements PickupOptionSummaryTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PickupOptionSummaryInterface
    {
        $pickupOptionSummary = new PickupOptionSummary();

        self::applyPickupLocationType($pickupOptionSummary, $data);

        return $pickupOptionSummary;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPickupLocationType(PickupOptionSummary $pickupOptionSummary, array $data): void
    {
        if (empty($data[self::KEY_PICKUP_LOCATION_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_PICKUP_LOCATION_TYPE])) {
            return;
        }
        $pickupOptionSummary->setPickupLocationType($data[self::KEY_PICKUP_LOCATION_TYPE]);
    }
}
