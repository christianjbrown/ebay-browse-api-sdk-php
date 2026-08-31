<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ItemLocation;
use ChristianBrown\EBay\Browse\Model\ItemLocationInterface;

use function is_string;
use function sprintf;

final class ItemLocationTransformer implements ItemLocationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemLocationInterface
    {
        if (empty($data[self::KEY_COUNTRY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COUNTRY));
        }
        if (!is_string($data[self::KEY_COUNTRY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_COUNTRY));
        }
        $itemLocation = new ItemLocation($data[self::KEY_COUNTRY]);

        self::applyAddressLine1($itemLocation, $data);
        self::applyAddressLine2($itemLocation, $data);
        self::applyCity($itemLocation, $data);
        self::applyCounty($itemLocation, $data);
        self::applyPostalCode($itemLocation, $data);
        self::applyStateOrProvince($itemLocation, $data);

        return $itemLocation;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine1(ItemLocation $itemLocation, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE_1])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE_1])) {
            return;
        }
        $itemLocation->setAddressLine1($data[self::KEY_ADDRESS_LINE_1]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine2(ItemLocation $itemLocation, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE_2])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE_2])) {
            return;
        }
        $itemLocation->setAddressLine2($data[self::KEY_ADDRESS_LINE_2]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCity(ItemLocation $itemLocation, array $data): void
    {
        if (empty($data[self::KEY_CITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CITY])) {
            return;
        }
        $itemLocation->setCity($data[self::KEY_CITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCounty(ItemLocation $itemLocation, array $data): void
    {
        if (empty($data[self::KEY_COUNTY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTY])) {
            return;
        }
        $itemLocation->setCounty($data[self::KEY_COUNTY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(ItemLocation $itemLocation, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $itemLocation->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStateOrProvince(ItemLocation $itemLocation, array $data): void
    {
        if (empty($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        $itemLocation->setStateOrProvince($data[self::KEY_STATE_OR_PROVINCE]);
    }
}
