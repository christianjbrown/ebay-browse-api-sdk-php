<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemSummaryInterface;

interface ItemSummaryTransformerInterface
{
    public const string KEY_ADDITIONAL_IMAGES = 'additionalImages';
    public const string KEY_ADULT_ONLY = 'adultOnly';
    public const string KEY_AVAILABLE_COUPONS = 'availableCoupons';
    public const string KEY_BID_COUNT = 'bidCount';
    public const string KEY_BUYING_OPTIONS = 'buyingOptions';
    public const string KEY_CATEGORIES = 'categories';
    public const string KEY_CONDITION = 'condition';
    public const string KEY_CONDITION_ID = 'conditionId';
    public const string KEY_CURRENT_BID_PRICE = 'currentBidPrice';
    public const string KEY_ENERGY_EFFICIENCY_CLASS = 'energyEfficiencyClass';
    public const string KEY_EPID = 'epid';
    public const string KEY_IMAGE = 'image';
    public const string KEY_ITEM_AFFILIATE_WEB_URL = 'itemAffiliateWebUrl';
    public const string KEY_ITEM_CREATION_DATE = 'itemCreationDate';
    public const string KEY_ITEM_END_DATE = 'itemEndDate';
    public const string KEY_ITEM_GROUP_HREF = 'itemGroupHref';
    public const string KEY_ITEM_GROUP_TYPE = 'itemGroupType';
    public const string KEY_ITEM_HREF = 'itemHref';
    public const string KEY_ITEM_ID = 'itemId';
    public const string KEY_ITEM_LOCATION = 'itemLocation';
    public const string KEY_ITEM_ORIGIN_DATE = 'itemOriginDate';
    public const string KEY_ITEM_WEB_URL = 'itemWebUrl';
    public const string KEY_LEAF_CATEGORY_IDS = 'leafCategoryIds';
    public const string KEY_LEGACY_ITEM_ID = 'legacyItemId';
    public const string KEY_LISTING_MARKETPLACE_ID = 'listingMarketplaceId';
    public const string KEY_MARKETING_PRICE = 'marketingPrice';
    public const string KEY_PRICE = 'price';
    public const string KEY_PRIORITY_LISTING = 'priorityListing';
    public const string KEY_SELLER = 'seller';
    public const string KEY_SHIPPING_OPTIONS = 'shippingOptions';
    public const string KEY_SHORT_DESCRIPTION = 'shortDescription';
    public const string KEY_THUMBNAIL_IMAGES = 'thumbnailImages';
    public const string KEY_TITLE = 'title';
    public const string KEY_TOP_RATED_BUYING_EXPERIENCE = 'topRatedBuyingExperience';
    public const string KEY_UNIT_PRICE = 'unitPrice';
    public const string KEY_UNIT_PRICING_MEASURE = 'unitPricingMeasure';
    public const string KEY_WATCH_COUNT = 'watchCount';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemSummaryInterface;
}
