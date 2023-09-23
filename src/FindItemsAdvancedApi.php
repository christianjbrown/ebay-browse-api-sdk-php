<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService;

use ChristianBrown\eBay\FindServiceApi\Model\ResultSet;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemsTransformer;

final class FindItemsAdvancedApi extends AbstractFindServiceApi implements FindItemsAdvancedApiInterface
{
    private ItemsTransformer $itemsTransformer;

    public function __construct(string $clientId)
    {
        parent::__construct($clientId);
        $this->itemsTransformer = new ItemsTransformer();
    }

    public function getBySeller(string $username, int $offset = 0, ?int $limit = null): ResultSet
    {
        $params = [
            self::API_KEY_ITEM_FILTER_NAME => self::API_VALUE_ITEM_FILTER_NAME,
            self::API_KEY_ITEM_FILTER_VALUE => $username,
        ];

        /** @todo Use $offset and $limit */
        $result = $this->getMultiple($params, self::API_VALUE_OPERATION_NAME_FIND_ITEMS_ADVANCED, $this->itemsTransformer);

        return $result;
    }
}
