<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Api;

use ChristianBrown\EBay\Browse\Model\CompatibilityResponseInterface;

interface ItemCompatibilityApiInterface extends ApiInterface
{
    public const string API_URL_SPRINTF = 'https://api.ebay.com/buy/browse/v1/item/%s/check_compatibility';
    public const string ITEM_NOT_FOUND_SPRINTF = 'Item %s was not found';
    public const string KEY_COMPATIBILITY_PROPERTIES = 'compatibilityProperties';
    public const string KEY_NAME = 'name';
    public const string KEY_VALUE = 'value';
    public const string MISSING_COMPATIBILITY_PROPERTIES = 'At least one compatibility property is required';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * @param string                $itemId                  The Browse API item id, e.g. `v1|123456789012|0`
     * @param array<string, string> $compatibilityProperties Aspect name => value, e.g. `['Year' => '2016', 'Make' => 'Honda']`
     */
    public function check(string $itemId, array $compatibilityProperties): CompatibilityResponseInterface;
}
