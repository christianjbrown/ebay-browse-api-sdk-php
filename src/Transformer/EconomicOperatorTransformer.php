<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\EconomicOperator;
use ChristianBrown\EBay\Browse\Model\EconomicOperatorInterface;

use function is_string;

final class EconomicOperatorTransformer implements EconomicOperatorTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EconomicOperatorInterface
    {
        $economicOperator = new EconomicOperator();

        self::applyAddressLine1($economicOperator, $data);
        self::applyAddressLine2($economicOperator, $data);
        self::applyCity($economicOperator, $data);
        self::applyCompanyName($economicOperator, $data);
        self::applyCountry($economicOperator, $data);
        self::applyEmail($economicOperator, $data);
        self::applyPhone($economicOperator, $data);
        self::applyPostalCode($economicOperator, $data);
        self::applyStateOrProvince($economicOperator, $data);

        return $economicOperator;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine1(EconomicOperator $economicOperator, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        $economicOperator->setAddressLine1($data[self::KEY_ADDRESS_LINE1]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine2(EconomicOperator $economicOperator, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        $economicOperator->setAddressLine2($data[self::KEY_ADDRESS_LINE2]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCity(EconomicOperator $economicOperator, array $data): void
    {
        if (empty($data[self::KEY_CITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CITY])) {
            return;
        }
        $economicOperator->setCity($data[self::KEY_CITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCompanyName(EconomicOperator $economicOperator, array $data): void
    {
        if (empty($data[self::KEY_COMPANY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPANY_NAME])) {
            return;
        }
        $economicOperator->setCompanyName($data[self::KEY_COMPANY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountry(EconomicOperator $economicOperator, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY])) {
            return;
        }
        $economicOperator->setCountry($data[self::KEY_COUNTRY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEmail(EconomicOperator $economicOperator, array $data): void
    {
        if (empty($data[self::KEY_EMAIL])) {
            return;
        }
        if (!is_string($data[self::KEY_EMAIL])) {
            return;
        }
        $economicOperator->setEmail($data[self::KEY_EMAIL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPhone(EconomicOperator $economicOperator, array $data): void
    {
        if (empty($data[self::KEY_PHONE])) {
            return;
        }
        if (!is_string($data[self::KEY_PHONE])) {
            return;
        }
        $economicOperator->setPhone($data[self::KEY_PHONE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(EconomicOperator $economicOperator, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $economicOperator->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStateOrProvince(EconomicOperator $economicOperator, array $data): void
    {
        if (empty($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        $economicOperator->setStateOrProvince($data[self::KEY_STATE_OR_PROVINCE]);
    }
}
