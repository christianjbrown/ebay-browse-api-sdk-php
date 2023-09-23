<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService\Transformer;

use ChristianBrown\eBay\FindService\Model\ResultSet;

interface ResultSetTransformerInterface
{
    public const DATA_KEY_PAGINATION = 'paginationOutput';
    public const DATA_KEY_SEARCH_RESULT = 'searchResult';

    public function transform(array $data, DatasTransformerInterface $datasTransformer): ResultSet;
}
