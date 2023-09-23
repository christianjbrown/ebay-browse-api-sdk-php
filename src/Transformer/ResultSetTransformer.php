<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService\Transformer;

use ChristianBrown\UserFriendlyException\UserFriendlyException;
use ChristianBrown\eBay\FindService\Model\ResultSet;

final class ResultSetTransformer implements ResultSetTransformerInterface
{
    private PaginationTransformer $paginationTransformer;
    private SearchResultTransformer $searchResultTransformer;

    public function __construct()
    {
        $this->searchResultTransformer = new SearchResultTransformer();
        $this->paginationTransformer = new PaginationTransformer();
    }

    public function transform(array $data, DatasTransformerInterface $datasTransformer): ResultSet
    {
        if (!isset($data[self::DATA_KEY_SEARCH_RESULT][0]) || !is_array($data[self::DATA_KEY_SEARCH_RESULT][0])) {
            throw new UserFriendlyException('eBay search result array is unexpected');
        }
        $objects = $this->searchResultTransformer->transform($data[self::DATA_KEY_SEARCH_RESULT][0], $datasTransformer);

        if (!isset($data[self::DATA_KEY_PAGINATION][0]) || !is_array($data[self::DATA_KEY_PAGINATION][0])) {
            throw new UserFriendlyException('eBay search result pagination is unexpected');
        }
        $pagination = $this->paginationTransformer->transform($data[self::DATA_KEY_PAGINATION][0]);

        return new ResultSet($pagination, $objects);
    }
}
