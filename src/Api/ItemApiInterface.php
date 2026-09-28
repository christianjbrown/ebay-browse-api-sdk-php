<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Api;

use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ItemsResponseInterface;

interface ItemApiInterface extends ApiInterface
{
    public const string API_URL_ITEM_BY_LEGACY_ID = 'https://api.ebay.com/buy/browse/v1/item/get_item_by_legacy_id';
    public const string API_URL_ITEM_SPRINTF = 'https://api.ebay.com/buy/browse/v1/item/%s';
    public const string API_URL_ITEMS = 'https://api.ebay.com/buy/browse/v1/item';
    public const string API_URL_ITEMS_BY_ITEM_GROUP = 'https://api.ebay.com/buy/browse/v1/item/get_items_by_item_group';
    public const string BOTH_ITEM_IDS_AND_ITEM_GROUP_IDS_PROVIDED = 'Only one of itemIds or itemGroupIds may be given, not both';
    public const string INVALID_QUANTITY_FOR_SHIPPING_ESTIMATE = 'quantityForShippingEstimate must be a positive integer';
    public const string ITEM_NOT_FOUND_SPRINTF = 'Item %s was not found';
    public const string KEY_FIELDGROUPS = 'fieldgroups';
    public const string KEY_ITEM_GROUP_ID = 'item_group_id';
    public const string KEY_ITEM_GROUP_IDS = 'item_group_ids';
    public const string KEY_ITEM_IDS = 'item_ids';
    public const string KEY_LEGACY_ITEM_ID = 'legacy_item_id';
    public const string KEY_LEGACY_VARIATION_ID = 'legacy_variation_id';
    public const string KEY_LEGACY_VARIATION_SKU = 'legacy_variation_sku';
    public const string KEY_QUANTITY_FOR_SHIPPING_ESTIMATE = 'quantity_for_shipping_estimate';
    public const int MAX_ITEM_GROUP_IDS = 10;
    public const int MAX_ITEM_IDS = 20;
    public const string NEITHER_ITEM_IDS_NOR_ITEM_GROUP_IDS_PROVIDED = 'One of itemIds or itemGroupIds is required';

    /**
     * Relative to ApiHostInterface::browseApiUrl(); resolves to
     * self::API_URL_ITEM_BY_LEGACY_ID against the production host.
     */
    public const string PATH_ITEM_BY_LEGACY_ID = '/item/get_item_by_legacy_id';

    /**
     * Relative to ApiHostInterface::browseApiUrl(); resolves to
     * self::API_URL_ITEM_SPRINTF against the production host.
     */
    public const string PATH_ITEM_SPRINTF = '/item/%s';

    /**
     * Relative to ApiHostInterface::browseApiUrl(); resolves to
     * self::API_URL_ITEMS against the production host.
     */
    public const string PATH_ITEMS = '/item';

    /**
     * Relative to ApiHostInterface::browseApiUrl(); resolves to
     * self::API_URL_ITEMS_BY_ITEM_GROUP against the production host.
     */
    public const string PATH_ITEMS_BY_ITEM_GROUP = '/item/get_items_by_item_group';

    /**
     * getItems() is a Limited Release call (select partners only) and needs
     * this scope in addition to CredentialsInterface::SCOPE.
     */
    public const string SCOPE_BULK = 'https://api.ebay.com/oauth/api_scope https://api.ebay.com/oauth/api_scope/buy.item.bulk';
    public const string TOO_MANY_ITEM_GROUP_IDS_SPRINTF = 'No more than %d itemGroupIds may be given';
    public const string TOO_MANY_ITEM_IDS_SPRINTF = 'No more than %d itemIds may be given';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    /**
     * getItems() is a Limited Release Browse API call available to select
     * partners only; it needs the extra `buy.item.bulk` OAuth scope (see
     * self::SCOPE_BULK) on top of the application's usual grant. Exactly one
     * of $itemIds / $itemGroupIds must be given.
     *
     * @param array<int, string> $itemIds      Up to self::MAX_ITEM_IDS Browse item ids
     * @param array<int, string> $itemGroupIds Up to self::MAX_ITEM_GROUP_IDS item group ids
     */
    public function getItems(array $itemIds = [], array $itemGroupIds = [], ?int $quantityForShippingEstimate = null, bool $skipCache = false): ItemsResponseInterface;

    public function getMultipleByItemGroupId(string $itemGroupId, bool $skipCache = false, ?int $quantityForShippingEstimate = null): ItemGroupInterface;

    public function getOneById(string $itemId, ?string $fieldgroups = null, bool $skipCache = false, ?int $quantityForShippingEstimate = null): ItemInterface;

    public function getOneByLegacyId(string $legacyItemId, ?string $legacyVariationId = null, ?string $legacyVariationSku = null, ?string $fieldgroups = null, bool $skipCache = false, ?int $quantityForShippingEstimate = null): ItemInterface;
}
