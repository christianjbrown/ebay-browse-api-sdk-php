<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Api;

interface ApiInterface
{
    public const string HEADER_KEY_CONTENT_TYPE = 'Content-Type';
    public const string HEADER_VALUE_CONTENT_TYPE_JSON = 'application/json';
    public const int HTTP_STATUS_NOT_FOUND = 404;
}
