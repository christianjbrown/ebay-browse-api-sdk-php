<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

use ChristianBrown\eBay\FindServiceApi\Model\PaginationInterface;

interface PaginationTransformerInterface
{
    public const string DATA_KEY_PAGINATION_ENTRIES_PER_PAGE = 'entriesPerPage';
    public const string DATA_KEY_PAGINATION_ENTRIES_TOTAL_ENTRIES = 'totalEntries';
    public const string DATA_KEY_PAGINATION_ENTRIES_TOTAL_PAGES = 'totalPages';
    public const string DATA_KEY_PAGINATION_PAGE_NUMBER = 'pageNumber';
    public const array DATA_KEYS = [
        self::DATA_KEY_PAGINATION_PAGE_NUMBER,
        self::DATA_KEY_PAGINATION_ENTRIES_PER_PAGE,
        self::DATA_KEY_PAGINATION_ENTRIES_TOTAL_PAGES,
        self::DATA_KEY_PAGINATION_ENTRIES_TOTAL_ENTRIES,
    ];

    public function transform(array $data): PaginationInterface;
}
