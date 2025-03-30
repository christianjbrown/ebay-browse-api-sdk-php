<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Request;

interface ApiInterface
{
    public const string API_KEY_ITEM_FILTER_NAME = 'itemFilter.name';
    public const string API_KEY_ITEM_FILTER_VALUE = 'itemFilter.value';
    public const string API_KEY_OPERATION_NAME = 'Operation-Name';
    public const string API_KEY_RESPONSE_DATA_FORMAT = 'Response-Data-Format';
    public const string API_KEY_SECURITY_APP_NAME = 'Security-AppName';
    public const string API_VALUE_RESPONSE_DATA_FORMAT_JSON = 'JSON';
    public const string DATA_KEY_ACK = 'ack';
    public const array DATA_VALUE_ACK_SUCCESS = ['Success'];
    public const string FRIENDLY_NAME = 'eBay\'s Find API';
    public const string URL = 'https://svcs.ebay.com/services/search/FindingService/v1';
}
