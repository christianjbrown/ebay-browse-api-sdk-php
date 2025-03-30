<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Endpoint;

use ChristianBrown\eBay\FindServiceApi\Model\ResultSetInterface;
use ChristianBrown\eBay\FindServiceApi\Request\ApiInterface;

interface FindItemsAdvancedApiInterface extends ApiInterface
{
    public const string API_VALUE_ITEM_FILTER_NAME = 'Seller';
    public const string OPERATION = 'findItemsAdvanced';

    public function getBySeller(string $username, int $offset = 0, ?int $limit = null): ResultSetInterface;
}
