<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\ItemInterface;

interface ItemTransformerInterface
{
    public const string KEY_ADDITIONAL_IMAGES = 'additionalImages';
    public const string KEY_ADULT_ONLY = 'adultOnly';
    public const string KEY_AGE_GROUP = 'ageGroup';
    public const string KEY_BID_COUNT = 'bidCount';
    public const string KEY_BRAND = 'brand';
    public const string KEY_BUYING_OPTIONS = 'buyingOptions';
    public const string KEY_CATEGORY_ID = 'categoryId';
    public const string KEY_CATEGORY_ID_PATH = 'categoryIdPath';
    public const string KEY_CATEGORY_PATH = 'categoryPath';
    public const string KEY_COLOR = 'color';
    public const string KEY_CONDITION = 'condition';
    public const string KEY_CONDITION_DESCRIPTION = 'conditionDescription';
    public const string KEY_CONDITION_ID = 'conditionId';
    public const string KEY_CURRENT_BID_PRICE = 'currentBidPrice';
    public const string KEY_DESCRIPTION = 'description';
    public const string KEY_ELIGIBLE_FOR_INLINE_CHECKOUT = 'eligibleForInlineCheckout';
    public const string KEY_ENABLED_FOR_GUEST_CHECKOUT = 'enabledForGuestCheckout';
    public const string KEY_ENERGY_EFFICIENCY_CLASS = 'energyEfficiencyClass';
    public const string KEY_EPID = 'epid';
    public const string KEY_ESTIMATED_AVAILABILITIES = 'estimatedAvailabilities';
    public const string KEY_GTIN = 'gtin';
    public const string KEY_IMAGE = 'image';
    public const string KEY_IMMEDIATE_PAY = 'immediatePay';
    public const string KEY_ITEM_AFFILIATE_WEB_URL = 'itemAffiliateWebUrl';
    public const string KEY_ITEM_CREATION_DATE = 'itemCreationDate';
    public const string KEY_ITEM_END_DATE = 'itemEndDate';
    public const string KEY_ITEM_ID = 'itemId';
    public const string KEY_ITEM_LOCATION = 'itemLocation';
    public const string KEY_ITEM_WEB_URL = 'itemWebUrl';
    public const string KEY_LEGACY_ITEM_ID = 'legacyItemId';
    public const string KEY_LISTING_MARKETPLACE_ID = 'listingMarketplaceId';
    public const string KEY_LOCALIZED_ASPECTS = 'localizedAspects';
    public const string KEY_LOT_SIZE = 'lotSize';
    public const string KEY_MARKETING_PRICE = 'marketingPrice';
    public const string KEY_MATERIAL = 'material';
    public const string KEY_MPN = 'mpn';
    public const string KEY_PAYMENT_METHODS = 'paymentMethods';
    public const string KEY_PRICE = 'price';
    public const string KEY_PRIORITY_LISTING = 'priorityListing';
    public const string KEY_PRODUCT = 'product';
    public const string KEY_RETURN_TERMS = 'returnTerms';
    public const string KEY_SELLER = 'seller';
    public const string KEY_SELLER_ITEM_REVISION = 'sellerItemRevision';
    public const string KEY_SHIP_TO_LOCATIONS = 'shipToLocations';
    public const string KEY_SHIPPING_OPTIONS = 'shippingOptions';
    public const string KEY_SHORT_DESCRIPTION = 'shortDescription';
    public const string KEY_SUBTITLE = 'subtitle';
    public const string KEY_TITLE = 'title';
    public const string KEY_TOP_RATED_BUYING_EXPERIENCE = 'topRatedBuyingExperience';
    public const string KEY_UNIQUE_BIDDER_COUNT = 'uniqueBidderCount';
    public const string KEY_UNIT_PRICE = 'unitPrice';
    public const string KEY_UNIT_PRICING_MEASURE = 'unitPricingMeasure';
    public const string KEY_WARNINGS = 'warnings';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemInterface;
}
