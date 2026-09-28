<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ResponsiblePerson;
use ChristianBrown\EBay\Browse\Model\ResponsiblePersonInterface;

use function is_array;
use function is_string;

final class ResponsiblePersonTransformer implements ResponsiblePersonTransformerInterface
{
    private StringsTransformerInterface $stringsTransformer;

    public function __construct(StringsTransformerInterface $stringsTransformer)
    {
        $this->stringsTransformer = $stringsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ResponsiblePersonInterface
    {
        $responsiblePerson = new ResponsiblePerson();

        self::applyAddressLine1($responsiblePerson, $data);
        self::applyAddressLine2($responsiblePerson, $data);
        self::applyCity($responsiblePerson, $data);
        self::applyCompanyName($responsiblePerson, $data);
        self::applyContactUrl($responsiblePerson, $data);
        self::applyCountry($responsiblePerson, $data);
        self::applyCountryName($responsiblePerson, $data);
        self::applyCounty($responsiblePerson, $data);
        self::applyEmail($responsiblePerson, $data);
        self::applyPhone($responsiblePerson, $data);
        self::applyPostalCode($responsiblePerson, $data);
        self::applyStateOrProvince($responsiblePerson, $data);
        $this->applyTypes($responsiblePerson, $data);

        return $responsiblePerson;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine1(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE1])) {
            return;
        }
        $responsiblePerson->setAddressLine1($data[self::KEY_ADDRESS_LINE1]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAddressLine2(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        if (!is_string($data[self::KEY_ADDRESS_LINE2])) {
            return;
        }
        $responsiblePerson->setAddressLine2($data[self::KEY_ADDRESS_LINE2]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCity(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_CITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CITY])) {
            return;
        }
        $responsiblePerson->setCity($data[self::KEY_CITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCompanyName(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_COMPANY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPANY_NAME])) {
            return;
        }
        $responsiblePerson->setCompanyName($data[self::KEY_COMPANY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyContactUrl(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_CONTACT_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_CONTACT_URL])) {
            return;
        }
        $responsiblePerson->setContactUrl($data[self::KEY_CONTACT_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountry(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY])) {
            return;
        }
        $responsiblePerson->setCountry($data[self::KEY_COUNTRY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCountryName(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_COUNTRY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTRY_NAME])) {
            return;
        }
        $responsiblePerson->setCountryName($data[self::KEY_COUNTRY_NAME]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCounty(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_COUNTY])) {
            return;
        }
        if (!is_string($data[self::KEY_COUNTY])) {
            return;
        }
        $responsiblePerson->setCounty($data[self::KEY_COUNTY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEmail(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_EMAIL])) {
            return;
        }
        if (!is_string($data[self::KEY_EMAIL])) {
            return;
        }
        $responsiblePerson->setEmail($data[self::KEY_EMAIL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPhone(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_PHONE])) {
            return;
        }
        if (!is_string($data[self::KEY_PHONE])) {
            return;
        }
        $responsiblePerson->setPhone($data[self::KEY_PHONE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPostalCode(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        if (!is_string($data[self::KEY_POSTAL_CODE])) {
            return;
        }
        $responsiblePerson->setPostalCode($data[self::KEY_POSTAL_CODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStateOrProvince(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE_OR_PROVINCE])) {
            return;
        }
        $responsiblePerson->setStateOrProvince($data[self::KEY_STATE_OR_PROVINCE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTypes(ResponsiblePerson $responsiblePerson, array $data): void
    {
        if (empty($data[self::KEY_TYPES])) {
            return;
        }
        if (!is_array($data[self::KEY_TYPES])) {
            return;
        }
        $responsiblePerson->setTypes($this->stringsTransformer->transform($data[self::KEY_TYPES]));
    }
}
