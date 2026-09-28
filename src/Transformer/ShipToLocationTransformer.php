<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ShipToLocation;
use ChristianBrown\EBay\Browse\Model\ShipToLocationInterface;

use function is_string;

final class ShipToLocationTransformer implements ShipToLocationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ShipToLocationInterface
    {
        $shipToLocation = new ShipToLocation();

        self::applyCountry($shipToLocation, $data);
        self::applyPostalCode($shipToLocation, $data);

        return $shipToLocation;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountry(ShipToLocation $shipToLocation, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY])) {
            return;
        }
        $shipToLocation->setCountry($data[self::KEY_COUNTRY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(ShipToLocation $shipToLocation, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $shipToLocation->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }
}
