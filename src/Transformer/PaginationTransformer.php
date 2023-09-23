<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService\Transformer;

use ChristianBrown\UserFriendlyException\UserFriendlyException;
use ChristianBrown\eBay\FindService\Model\Pagination;

final class PaginationTransformer implements PaginationTransformerInterface
{
    public function transform(array $data): Pagination
    {
        foreach (self::DATA_KEYS as $key) {
            if (!isset($data[$key]) || !is_array($data[$key]) || 1 !== count($data[$key]) || !isset($data[$key][0]) || !is_numeric($data[$key][0])) {
                throw new UserFriendlyException(sprintf('eBay search result pagination %s is unexpected', $key));
            }
        }
        $totalEntries = (int) $data[self::DATA_KEY_PAGINATION_ENTRIES_TOTAL_ENTRIES][0];
        $pageNumber = (int) $data[self::DATA_KEY_PAGINATION_PAGE_NUMBER][0];
        $perPage = (int) $data[self::DATA_KEY_PAGINATION_ENTRIES_PER_PAGE][0];
        $totalPages = (int) $data[self::DATA_KEY_PAGINATION_ENTRIES_TOTAL_PAGES][0];

        return new Pagination($totalEntries, $pageNumber, $perPage, $totalPages);
    }
}
