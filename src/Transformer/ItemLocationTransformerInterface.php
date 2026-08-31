<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemLocationInterface;

interface ItemLocationTransformerInterface
{
    public const string KEY_ADDRESS_LINE_1 = 'addressLine1';
    public const string KEY_ADDRESS_LINE_2 = 'addressLine2';
    public const string KEY_CITY = 'city';
    public const string KEY_COUNTRY = 'country';
    public const string KEY_COUNTY = 'county';
    public const string KEY_POSTAL_CODE = 'postalCode';
    public const string KEY_STATE_OR_PROVINCE = 'stateOrProvince';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemLocationInterface;
}
