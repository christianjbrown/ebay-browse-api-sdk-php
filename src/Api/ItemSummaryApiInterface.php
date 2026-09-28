<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Api;

use ChristianBrown\EBay\Browse\Model\SearchPagedCollectionInterface;

interface ItemSummaryApiInterface extends ApiInterface
{
    public const string API_URL_SEARCH = 'https://api.ebay.com/buy/browse/v1/item_summary/search';
    public const string API_URL_SEARCH_BY_IMAGE = 'https://api.ebay.com/buy/browse/v1/item_summary/search_by_image';
    public const string KEY_ASPECT_FILTER = 'aspect_filter';
    public const string KEY_AUTO_CORRECT = 'auto_correct';
    public const string KEY_CATEGORY_IDS = 'category_ids';
    public const string KEY_CHARITY_IDS = 'charity_ids';
    public const string KEY_COMPATIBILITY_FILTER = 'compatibility_filter';
    public const string KEY_EPID = 'epid';
    public const string KEY_FIELDGROUPS = 'fieldgroups';
    public const string KEY_FILTER = 'filter';
    public const string KEY_GTIN = 'gtin';
    public const string KEY_IMAGE = 'image';
    public const string KEY_LIMIT = 'limit';
    public const string KEY_OFFSET = 'offset';
    public const string KEY_Q = 'q';
    public const string KEY_SORT = 'sort';
    public const string MISSING_IMAGE = 'A base64-encoded image is required';

    /**
     * Relative to ApiHostInterface::browseApiUrl(); resolves to
     * self::API_URL_SEARCH against the production host.
     */
    public const string PATH_SEARCH = '/item_summary/search';

    /**
     * Relative to ApiHostInterface::browseApiUrl(); resolves to
     * self::API_URL_SEARCH_BY_IMAGE against the production host.
     */
    public const string PATH_SEARCH_BY_IMAGE = '/item_summary/search_by_image';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';
    public const string VALUE_AUTO_CORRECT_KEYWORD = 'KEYWORD';

    public function search(?string $q = null, ?string $gtin = null, ?string $charityIds = null, ?string $categoryIds = null, ?string $epid = null, ?string $aspectFilter = null, ?string $compatibilityFilter = null, ?string $filter = null, ?string $sort = null, ?string $fieldgroups = null, ?string $autoCorrect = null, int $limit = 50, int $offset = 0, bool $skipCache = false): SearchPagedCollectionInterface;

    public function searchByImage(string $image, ?string $charityIds = null, ?string $categoryIds = null, ?string $aspectFilter = null, ?string $filter = null, ?string $sort = null, ?string $fieldgroups = null, int $limit = 50, int $offset = 0): SearchPagedCollectionInterface;
}
