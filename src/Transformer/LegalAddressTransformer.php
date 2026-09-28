<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\LegalAddress;
use ChristianBrown\EBay\Browse\Model\LegalAddressInterface;

use function is_string;

final class LegalAddressTransformer implements LegalAddressTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LegalAddressInterface
    {
        $legalAddress = new LegalAddress();

        self::applyAddressLine1($legalAddress, $data);
        self::applyAddressLine2($legalAddress, $data);
        self::applyCity($legalAddress, $data);
        self::applyCountry($legalAddress, $data);
        self::applyCountryName($legalAddress, $data);
        self::applyCounty($legalAddress, $data);
        self::applyPostalCode($legalAddress, $data);
        self::applyStateOrProvince($legalAddress, $data);

        return $legalAddress;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine1(LegalAddress $legalAddress, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        $legalAddress->setAddressLine1($data[self::KEY_ADDRESS_LINE1]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine2(LegalAddress $legalAddress, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        $legalAddress->setAddressLine2($data[self::KEY_ADDRESS_LINE2]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCity(LegalAddress $legalAddress, array $data): void
    {
        if (empty($data[self::KEY_CITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CITY])) {
            return;
        }
        $legalAddress->setCity($data[self::KEY_CITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountry(LegalAddress $legalAddress, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY])) {
            return;
        }
        $legalAddress->setCountry($data[self::KEY_COUNTRY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountryName(LegalAddress $legalAddress, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY_NAME])) {
            return;
        }
        $legalAddress->setCountryName($data[self::KEY_COUNTRY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCounty(LegalAddress $legalAddress, array $data): void
    {
        if (empty($data[self::KEY_COUNTY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTY])) {
            return;
        }
        $legalAddress->setCounty($data[self::KEY_COUNTY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(LegalAddress $legalAddress, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $legalAddress->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStateOrProvince(LegalAddress $legalAddress, array $data): void
    {
        if (empty($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        $legalAddress->setStateOrProvince($data[self::KEY_STATE_OR_PROVINCE]);
    }
}
