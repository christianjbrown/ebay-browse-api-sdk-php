<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService\Transformer;

use ChristianBrown\UserFriendlyException\UserFriendlyException;

final class SearchResultTransformer implements SearchResultTransformerInterface
{
    public function transform(array $data, DatasTransformerInterface $datasTransformer): array
    {
        if (!isset($data[self::DATA_KEY_SEARCH_RESULT_ITEM]) || !is_array($data[self::DATA_KEY_SEARCH_RESULT_ITEM])) {
            throw new UserFriendlyException('eBay search result item array is unexpected');
        }
        $searchResultItems = $data[self::DATA_KEY_SEARCH_RESULT_ITEM];

        return $datasTransformer->transform($searchResultItems);
    }
}
