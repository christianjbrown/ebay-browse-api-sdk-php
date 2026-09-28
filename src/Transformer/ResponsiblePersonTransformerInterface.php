<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ResponsiblePersonInterface;

interface ResponsiblePersonTransformerInterface
{
    public const string KEY_ADDRESS_LINE1 = 'addressLine1';
    public const string KEY_ADDRESS_LINE2 = 'addressLine2';
    public const string KEY_CITY = 'city';
    public const string KEY_COMPANY_NAME = 'companyName';
    public const string KEY_CONTACT_URL = 'contactUrl';
    public const string KEY_COUNTRY = 'country';
    public const string KEY_COUNTRY_NAME = 'countryName';
    public const string KEY_COUNTY = 'county';
    public const string KEY_EMAIL = 'email';
    public const string KEY_PHONE = 'phone';
    public const string KEY_POSTAL_CODE = 'postalCode';
    public const string KEY_STATE_OR_PROVINCE = 'stateOrProvince';
    public const string KEY_TYPES = 'types';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ResponsiblePersonInterface;
}
