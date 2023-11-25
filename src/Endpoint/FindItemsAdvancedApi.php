<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Endpoint;

use ChristianBrown\eBay\FindServiceApi\Model\ResultSetInterface;
use ChristianBrown\eBay\FindServiceApi\Request\RequestMultipleApiInterface;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemsTransformerInterface;

final class FindItemsAdvancedApi implements FindItemsAdvancedApiInterface
{
    private ItemsTransformerInterface $itemsTransformer;
    private RequestMultipleApiInterface $requestMultipleApi;

    public function __construct(RequestMultipleApiInterface $requestMultipleApi, ItemsTransformerInterface $itemsTransformer)
    {
        $this->requestMultipleApi = $requestMultipleApi;
        $this->itemsTransformer = $itemsTransformer;
    }

    public function getBySeller(string $username, int $offset = 0, ?int $limit = null): ResultSetInterface
    {
        /** @todo Use $offset and $limit */
        $params = [
            self::API_KEY_ITEM_FILTER_NAME => self::API_VALUE_ITEM_FILTER_NAME,
            self::API_KEY_ITEM_FILTER_VALUE => $username,
        ];

        $result = $this->requestMultipleApi->getMultiple($this->itemsTransformer, self::OPERATION, $params);

        return $result;
    }
}
