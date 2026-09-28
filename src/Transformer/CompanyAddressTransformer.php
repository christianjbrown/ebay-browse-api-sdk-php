<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\CompanyAddress;
use ChristianBrown\EBay\Browse\Model\CompanyAddressInterface;

use function is_string;

final class CompanyAddressTransformer implements CompanyAddressTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CompanyAddressInterface
    {
        $companyAddress = new CompanyAddress();

        self::applyAddressLine1($companyAddress, $data);
        self::applyAddressLine2($companyAddress, $data);
        self::applyCity($companyAddress, $data);
        self::applyCompanyName($companyAddress, $data);
        self::applyContactUrl($companyAddress, $data);
        self::applyCountry($companyAddress, $data);
        self::applyCountryName($companyAddress, $data);
        self::applyCounty($companyAddress, $data);
        self::applyEmail($companyAddress, $data);
        self::applyPhone($companyAddress, $data);
        self::applyPostalCode($companyAddress, $data);
        self::applyStateOrProvince($companyAddress, $data);

        return $companyAddress;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine1(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        $companyAddress->setAddressLine1($data[self::KEY_ADDRESS_LINE1]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine2(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        $companyAddress->setAddressLine2($data[self::KEY_ADDRESS_LINE2]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCity(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_CITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CITY])) {
            return;
        }
        $companyAddress->setCity($data[self::KEY_CITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCompanyName(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_COMPANY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPANY_NAME])) {
            return;
        }
        $companyAddress->setCompanyName($data[self::KEY_COMPANY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyContactUrl(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_CONTACT_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_CONTACT_URL])) {
            return;
        }
        $companyAddress->setContactUrl($data[self::KEY_CONTACT_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountry(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY])) {
            return;
        }
        $companyAddress->setCountry($data[self::KEY_COUNTRY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountryName(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY_NAME])) {
            return;
        }
        $companyAddress->setCountryName($data[self::KEY_COUNTRY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCounty(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_COUNTY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTY])) {
            return;
        }
        $companyAddress->setCounty($data[self::KEY_COUNTY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEmail(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_EMAIL])) {
            return;
        }
        if (!is_string($data[self::KEY_EMAIL])) {
            return;
        }
        $companyAddress->setEmail($data[self::KEY_EMAIL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPhone(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_PHONE])) {
            return;
        }
        if (!is_string($data[self::KEY_PHONE])) {
            return;
        }
        $companyAddress->setPhone($data[self::KEY_PHONE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $companyAddress->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStateOrProvince(CompanyAddress $companyAddress, array $data): void
    {
        if (empty($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        $companyAddress->setStateOrProvince($data[self::KEY_STATE_OR_PROVINCE]);
    }
}
