<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Request;

use ChristianBrown\eBay\FindServiceApi\Model\ResultSetInterface;
use ChristianBrown\eBay\FindServiceApi\Transformer\ObjectsTransformerInterface;

interface RequestMultipleApiInterface extends ApiInterface
{
    public const DATA_KEY_PAGINATION = 'paginationOutput';
    public const DATA_KEY_SEARCH_RESULT = 'searchResult';
    public const DATA_KEY_SEARCH_RESULT_0_ITEM = 'item';

    public function getMultiple(ObjectsTransformerInterface $objectsTransformer, string $operationName, array $params = []): ResultSetInterface;
}
