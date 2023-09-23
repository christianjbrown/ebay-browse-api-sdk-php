<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService\Transformer;

use ChristianBrown\eBay\FindService\Model\Pagination;

interface PaginationTransformerInterface
{
    public const DATA_KEY_PAGINATION_ENTRIES_PER_PAGE = 'entriesPerPage';
    public const DATA_KEY_PAGINATION_ENTRIES_TOTAL_ENTRIES = 'totalEntries';
    public const DATA_KEY_PAGINATION_ENTRIES_TOTAL_PAGES = 'totalPages';
    public const DATA_KEY_PAGINATION_PAGE_NUMBER = 'pageNumber';
    public const DATA_KEYS = [
        self::DATA_KEY_PAGINATION_PAGE_NUMBER,
        self::DATA_KEY_PAGINATION_ENTRIES_PER_PAGE,
        self::DATA_KEY_PAGINATION_ENTRIES_TOTAL_PAGES,
        self::DATA_KEY_PAGINATION_ENTRIES_TOTAL_ENTRIES,
    ];

    public function transform(array $data): Pagination;
}
