<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi;

interface FindServiceApiInterface
{
    public const API_KEY_ITEM_FILTER_NAME = 'itemFilter.name';
    public const API_KEY_ITEM_FILTER_VALUE = 'itemFilter.value';
    public const API_KEY_OPERATION_NAME = 'Operation-Name';
    public const API_KEY_RESPONSE_DATA_FORMAT = 'Response-Data-Format';
    public const API_KEY_SECURITY_APP_NAME = 'Security-AppName';
    public const API_VALUE_ITEM_FILTER_NAME = 'Seller';
    public const API_VALUE_RESPONSE_DATA_FORMAT_JSON = 'JSON';
    public const DATA_KEY_ACK = 'ack';
    public const DATA_VALUE_ACK_SUCCESS = ['Success'];
    public const FRIENDLY_NAME = 'eBay\'s Find API';
    public const URL = 'https://svcs.ebay.com/services/search/FindingService/v1';
}
