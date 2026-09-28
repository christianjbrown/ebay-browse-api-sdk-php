<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Api;

use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;

interface ItemApiInterface extends ApiInterface
{
    public const string API_URL_ITEM_BY_LEGACY_ID = 'https://api.ebay.com/buy/browse/v1/item/get_item_by_legacy_id';
    public const string API_URL_ITEM_SPRINTF = 'https://api.ebay.com/buy/browse/v1/item/%s';
    public const string API_URL_ITEMS_BY_ITEM_GROUP = 'https://api.ebay.com/buy/browse/v1/item/get_items_by_item_group';
    public const string ITEM_NOT_FOUND_SPRINTF = 'Item %s was not found';
    public const string KEY_FIELDGROUPS = 'fieldgroups';
    public const string KEY_ITEM_GROUP_ID = 'item_group_id';
    public const string KEY_LEGACY_ITEM_ID = 'legacy_item_id';
    public const string KEY_LEGACY_VARIATION_ID = 'legacy_variation_id';
    public const string KEY_LEGACY_VARIATION_SKU = 'legacy_variation_sku';

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
     * self::API_URL_ITEMS_BY_ITEM_GROUP against the production host.
     */
    public const string PATH_ITEMS_BY_ITEM_GROUP = '/item/get_items_by_item_group';
    public const string UNEXPECTED_RESPONSE = 'Response not set or not an array';

    public function getMultipleByItemGroupId(string $itemGroupId, bool $skipCache = false): ItemGroupInterface;

    public function getOneById(string $itemId, ?string $fieldgroups = null, bool $skipCache = false): ItemInterface;

    public function getOneByLegacyId(string $legacyItemId, ?string $legacyVariationId = null, ?string $legacyVariationSku = null, ?string $fieldgroups = null, bool $skipCache = false): ItemInterface;
}
