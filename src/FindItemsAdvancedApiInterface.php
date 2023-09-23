<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi;

use ChristianBrown\eBay\FindServiceApi\Model\ResultSet;

interface FindItemsAdvancedApiInterface extends FindServiceApiInterface
{
    public const API_VALUE_OPERATION_NAME_FIND_ITEMS_ADVANCED = 'findItemsAdvanced';

    public function getBySeller(string $username, int $offset = 0, ?int $limit = null): ResultSet;
}
