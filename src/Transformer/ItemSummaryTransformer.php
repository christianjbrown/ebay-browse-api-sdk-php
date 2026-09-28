<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ItemSummary;
use ChristianBrown\EBay\Browse\Model\ItemSummaryInterface;

use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function sprintf;
use function strtotime;

final class ItemSummaryTransformer implements ItemSummaryTransformerInterface
{
    private CategoriesTransformerInterface $categoriesTransformer;
    private CompatibilityPropertiesTransformerInterface $compatibilityPropertiesTransformer;
    private ConvertedAmountTransformerInterface $convertedAmountTransformer;
    private ImagesTransformerInterface $imagesTransformer;
    private ImageTransformerInterface $imageTransformer;
    private ItemLocationTransformerInterface $itemLocationTransformer;
    private MarketingPriceTransformerInterface $marketingPriceTransformer;
    private PickupOptionSummariesTransformerInterface $pickupOptionSummariesTransformer;
    private SellerTransformerInterface $sellerTransformer;
    private ShippingOptionsTransformerInterface $shippingOptionsTransformer;
    private StringsTransformerInterface $stringsTransformer;
    private TargetLocationTransformerInterface $targetLocationTransformer;

    public function __construct(CategoriesTransformerInterface $categoriesTransformer, CompatibilityPropertiesTransformerInterface $compatibilityPropertiesTransformer, ConvertedAmountTransformerInterface $convertedAmountTransformer, ImageTransformerInterface $imageTransformer, ImagesTransformerInterface $imagesTransformer, ItemLocationTransformerInterface $itemLocationTransformer, MarketingPriceTransformerInterface $marketingPriceTransformer, PickupOptionSummariesTransformerInterface $pickupOptionSummariesTransformer, SellerTransformerInterface $sellerTransformer, ShippingOptionsTransformerInterface $shippingOptionsTransformer, StringsTransformerInterface $stringsTransformer, TargetLocationTransformerInterface $targetLocationTransformer)
    {
        $this->categoriesTransformer = $categoriesTransformer;
        $this->compatibilityPropertiesTransformer = $compatibilityPropertiesTransformer;
        $this->convertedAmountTransformer = $convertedAmountTransformer;
        $this->imageTransformer = $imageTransformer;
        $this->imagesTransformer = $imagesTransformer;
        $this->itemLocationTransformer = $itemLocationTransformer;
        $this->marketingPriceTransformer = $marketingPriceTransformer;
        $this->pickupOptionSummariesTransformer = $pickupOptionSummariesTransformer;
        $this->sellerTransformer = $sellerTransformer;
        $this->shippingOptionsTransformer = $shippingOptionsTransformer;
        $this->stringsTransformer = $stringsTransformer;
        $this->targetLocationTransformer = $targetLocationTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemSummaryInterface
    {
        if (empty($data[self::KEY_ITEM_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ITEM_ID));
        }
        if (!is_string($data[self::KEY_ITEM_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ITEM_ID));
        }
        $itemSummary = new ItemSummary($data[self::KEY_ITEM_ID]);

        $this->applyAdditionalImages($itemSummary, $data);
        self::applyAdultOnly($itemSummary, $data);
        self::applyAvailableCoupons($itemSummary, $data);
        self::applyBidCount($itemSummary, $data);
        $this->applyBuyingOptions($itemSummary, $data);
        $this->applyCategories($itemSummary, $data);
        self::applyCompatibilityMatch($itemSummary, $data);
        $this->applyCompatibilityProperties($itemSummary, $data);
        self::applyCondition($itemSummary, $data);
        self::applyConditionId($itemSummary, $data);
        $this->applyCurrentBidPrice($itemSummary, $data);
        $this->applyDistanceFromPickupLocation($itemSummary, $data);
        self::applyEnergyEfficiencyClass($itemSummary, $data);
        self::applyEpid($itemSummary, $data);
        $this->applyImage($itemSummary, $data);
        self::applyItemAffiliateWebUrl($itemSummary, $data);
        self::applyItemCreationDate($itemSummary, $data);
        self::applyItemEndDate($itemSummary, $data);
        self::applyItemGroupHref($itemSummary, $data);
        self::applyItemGroupType($itemSummary, $data);
        self::applyItemHref($itemSummary, $data);
        $this->applyItemLocation($itemSummary, $data);
        self::applyItemOriginDate($itemSummary, $data);
        self::applyItemWebUrl($itemSummary, $data);
        $this->applyLeafCategoryIds($itemSummary, $data);
        self::applyLegacyItemId($itemSummary, $data);
        self::applyListingMarketplaceId($itemSummary, $data);
        $this->applyMarketingPrice($itemSummary, $data);
        $this->applyPickupOptions($itemSummary, $data);
        $this->applyPrice($itemSummary, $data);
        self::applyPriceDisplayCondition($itemSummary, $data);
        self::applyPriorityListing($itemSummary, $data);
        $this->applyQualifiedPrograms($itemSummary, $data);
        $this->applySeller($itemSummary, $data);
        $this->applyShippingOptions($itemSummary, $data);
        self::applyShortDescription($itemSummary, $data);
        $this->applyThumbnailImages($itemSummary, $data);
        self::applyTitle($itemSummary, $data);
        self::applyTopRatedBuyingExperience($itemSummary, $data);
        self::applyTyreLabelImageUrl($itemSummary, $data);
        $this->applyUnitPrice($itemSummary, $data);
        self::applyUnitPricingMeasure($itemSummary, $data);
        self::applyWatchCount($itemSummary, $data);

        return $itemSummary;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAdditionalImages(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ADDITIONAL_IMAGES])) {
            return;
        }
        if (!is_array($data[self::KEY_ADDITIONAL_IMAGES])) {
            return;
        }
        $itemSummary->setAdditionalImages($this->imagesTransformer->transform($data[self::KEY_ADDITIONAL_IMAGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAdultOnly(ItemSummary $itemSummary, array $data): void
    {
        if (!isset($data[self::KEY_ADULT_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_ADULT_ONLY])) {
            return;
        }
        $itemSummary->setAdultOnly($data[self::KEY_ADULT_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAvailableCoupons(ItemSummary $itemSummary, array $data): void
    {
        if (!isset($data[self::KEY_AVAILABLE_COUPONS])) {
            return;
        }
        if (!is_bool($data[self::KEY_AVAILABLE_COUPONS])) {
            return;
        }
        $itemSummary->setAvailableCoupons($data[self::KEY_AVAILABLE_COUPONS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBidCount(ItemSummary $itemSummary, array $data): void
    {
        if (!isset($data[self::KEY_BID_COUNT])) {
            return;
        }
        if (!is_int($data[self::KEY_BID_COUNT])) {
            return;
        }
        $itemSummary->setBidCount($data[self::KEY_BID_COUNT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBuyingOptions(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_BUYING_OPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_BUYING_OPTIONS])) {
            return;
        }
        $itemSummary->setBuyingOptions($this->stringsTransformer->transform($data[self::KEY_BUYING_OPTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCategories(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_CATEGORIES])) {
            return;
        }
        if (!is_array($data[self::KEY_CATEGORIES])) {
            return;
        }
        $itemSummary->setCategories($this->categoriesTransformer->transform($data[self::KEY_CATEGORIES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCompatibilityMatch(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_COMPATIBILITY_MATCH])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPATIBILITY_MATCH])) {
            return;
        }
        $itemSummary->setCompatibilityMatch($data[self::KEY_COMPATIBILITY_MATCH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCompatibilityProperties(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_COMPATIBILITY_PROPERTIES])) {
            return;
        }
        if (!is_array($data[self::KEY_COMPATIBILITY_PROPERTIES])) {
            return;
        }
        $itemSummary->setCompatibilityProperties($this->compatibilityPropertiesTransformer->transform($data[self::KEY_COMPATIBILITY_PROPERTIES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCondition(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_CONDITION])) {
            return;
        }
        if (!is_string($data[self::KEY_CONDITION])) {
            return;
        }
        $itemSummary->setCondition($data[self::KEY_CONDITION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionId(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_CONDITION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CONDITION_ID])) {
            return;
        }
        $itemSummary->setConditionId($data[self::KEY_CONDITION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCurrentBidPrice(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_CURRENT_BID_PRICE])) {
            return;
        }
        if (!is_array($data[self::KEY_CURRENT_BID_PRICE])) {
            return;
        }
        $itemSummary->setCurrentBidPrice($this->convertedAmountTransformer->transform($data[self::KEY_CURRENT_BID_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDistanceFromPickupLocation(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_DISTANCE_FROM_PICKUP_LOCATION])) {
            return;
        }
        if (!is_array($data[self::KEY_DISTANCE_FROM_PICKUP_LOCATION])) {
            return;
        }
        $itemSummary->setDistanceFromPickupLocation($this->targetLocationTransformer->transform($data[self::KEY_DISTANCE_FROM_PICKUP_LOCATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEnergyEfficiencyClass(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ENERGY_EFFICIENCY_CLASS])) {
            return;
        }
        if (!is_string($data[self::KEY_ENERGY_EFFICIENCY_CLASS])) {
            return;
        }
        $itemSummary->setEnergyEfficiencyClass($data[self::KEY_ENERGY_EFFICIENCY_CLASS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEpid(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_EPID])) {
            return;
        }
        if (!is_string($data[self::KEY_EPID])) {
            return;
        }
        $itemSummary->setEpid($data[self::KEY_EPID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyImage(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_IMAGE])) {
            return;
        }
        if (!is_array($data[self::KEY_IMAGE])) {
            return;
        }
        $itemSummary->setImage($this->imageTransformer->transform($data[self::KEY_IMAGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemAffiliateWebUrl(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_AFFILIATE_WEB_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_AFFILIATE_WEB_URL])) {
            return;
        }
        $itemSummary->setItemAffiliateWebUrl($data[self::KEY_ITEM_AFFILIATE_WEB_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemCreationDate(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_CREATION_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_CREATION_DATE])) {
            return;
        }
        $timestamp = strtotime($data[self::KEY_ITEM_CREATION_DATE]);
        if (false === $timestamp) {
            return;
        }
        $itemSummary->setItemCreationDate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemEndDate(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_END_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_END_DATE])) {
            return;
        }
        $timestamp = strtotime($data[self::KEY_ITEM_END_DATE]);
        if (false === $timestamp) {
            return;
        }
        $itemSummary->setItemEndDate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemGroupHref(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_GROUP_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_GROUP_HREF])) {
            return;
        }
        $itemSummary->setItemGroupHref($data[self::KEY_ITEM_GROUP_HREF]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemGroupType(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_GROUP_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_GROUP_TYPE])) {
            return;
        }
        $itemSummary->setItemGroupType($data[self::KEY_ITEM_GROUP_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemHref(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_HREF])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_HREF])) {
            return;
        }
        $itemSummary->setItemHref($data[self::KEY_ITEM_HREF]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItemLocation(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_LOCATION])) {
            return;
        }
        if (!is_array($data[self::KEY_ITEM_LOCATION])) {
            return;
        }
        $itemSummary->setItemLocation($this->itemLocationTransformer->transform($data[self::KEY_ITEM_LOCATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemOriginDate(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_ORIGIN_DATE])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_ORIGIN_DATE])) {
            return;
        }
        $timestamp = strtotime($data[self::KEY_ITEM_ORIGIN_DATE]);
        if (false === $timestamp) {
            return;
        }
        $itemSummary->setItemOriginDate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemWebUrl(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_ITEM_WEB_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_WEB_URL])) {
            return;
        }
        $itemSummary->setItemWebUrl($data[self::KEY_ITEM_WEB_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLeafCategoryIds(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_LEAF_CATEGORY_IDS])) {
            return;
        }
        if (!is_array($data[self::KEY_LEAF_CATEGORY_IDS])) {
            return;
        }
        $itemSummary->setLeafCategoryIds($this->stringsTransformer->transform($data[self::KEY_LEAF_CATEGORY_IDS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLegacyItemId(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_LEGACY_ITEM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LEGACY_ITEM_ID])) {
            return;
        }
        $itemSummary->setLegacyItemId($data[self::KEY_LEGACY_ITEM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyListingMarketplaceId(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_LISTING_MARKETPLACE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LISTING_MARKETPLACE_ID])) {
            return;
        }
        $itemSummary->setListingMarketplaceId($data[self::KEY_LISTING_MARKETPLACE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMarketingPrice(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_MARKETING_PRICE])) {
            return;
        }
        if (!is_array($data[self::KEY_MARKETING_PRICE])) {
            return;
        }
        $itemSummary->setMarketingPrice($this->marketingPriceTransformer->transform($data[self::KEY_MARKETING_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPickupOptions(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_PICKUP_OPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_PICKUP_OPTIONS])) {
            return;
        }
        $itemSummary->setPickupOptions($this->pickupOptionSummariesTransformer->transform($data[self::KEY_PICKUP_OPTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPrice(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_PRICE])) {
            return;
        }
        if (!is_array($data[self::KEY_PRICE])) {
            return;
        }
        $itemSummary->setPrice($this->convertedAmountTransformer->transform($data[self::KEY_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPriceDisplayCondition(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_PRICE_DISPLAY_CONDITION])) {
            return;
        }
        if (!is_string($data[self::KEY_PRICE_DISPLAY_CONDITION])) {
            return;
        }
        $itemSummary->setPriceDisplayCondition($data[self::KEY_PRICE_DISPLAY_CONDITION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPriorityListing(ItemSummary $itemSummary, array $data): void
    {
        if (!isset($data[self::KEY_PRIORITY_LISTING])) {
            return;
        }
        if (!is_bool($data[self::KEY_PRIORITY_LISTING])) {
            return;
        }
        $itemSummary->setPriorityListing($data[self::KEY_PRIORITY_LISTING]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyQualifiedPrograms(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_QUALIFIED_PROGRAMS])) {
            return;
        }
        if (!is_array($data[self::KEY_QUALIFIED_PROGRAMS])) {
            return;
        }
        $itemSummary->setQualifiedPrograms($this->stringsTransformer->transform($data[self::KEY_QUALIFIED_PROGRAMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySeller(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_SELLER])) {
            return;
        }
        if (!is_array($data[self::KEY_SELLER])) {
            return;
        }
        $itemSummary->setSeller($this->sellerTransformer->transform($data[self::KEY_SELLER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShippingOptions(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_OPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_SHIPPING_OPTIONS])) {
            return;
        }
        $itemSummary->setShippingOptions($this->shippingOptionsTransformer->transform($data[self::KEY_SHIPPING_OPTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShortDescription(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_SHORT_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_SHORT_DESCRIPTION])) {
            return;
        }
        $itemSummary->setShortDescription($data[self::KEY_SHORT_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyThumbnailImages(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_THUMBNAIL_IMAGES])) {
            return;
        }
        if (!is_array($data[self::KEY_THUMBNAIL_IMAGES])) {
            return;
        }
        $itemSummary->setThumbnailImages($this->imagesTransformer->transform($data[self::KEY_THUMBNAIL_IMAGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_TITLE])) {
            return;
        }
        $itemSummary->setTitle($data[self::KEY_TITLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTopRatedBuyingExperience(ItemSummary $itemSummary, array $data): void
    {
        if (!isset($data[self::KEY_TOP_RATED_BUYING_EXPERIENCE])) {
            return;
        }
        if (!is_bool($data[self::KEY_TOP_RATED_BUYING_EXPERIENCE])) {
            return;
        }
        $itemSummary->setTopRatedBuyingExperience($data[self::KEY_TOP_RATED_BUYING_EXPERIENCE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTyreLabelImageUrl(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_TYRE_LABEL_IMAGE_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_TYRE_LABEL_IMAGE_URL])) {
            return;
        }
        $itemSummary->setTyreLabelImageUrl($data[self::KEY_TYRE_LABEL_IMAGE_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyUnitPrice(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_UNIT_PRICE])) {
            return;
        }
        if (!is_array($data[self::KEY_UNIT_PRICE])) {
            return;
        }
        $itemSummary->setUnitPrice($this->convertedAmountTransformer->transform($data[self::KEY_UNIT_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnitPricingMeasure(ItemSummary $itemSummary, array $data): void
    {
        if (empty($data[self::KEY_UNIT_PRICING_MEASURE])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIT_PRICING_MEASURE])) {
            return;
        }
        $itemSummary->setUnitPricingMeasure($data[self::KEY_UNIT_PRICING_MEASURE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWatchCount(ItemSummary $itemSummary, array $data): void
    {
        if (!isset($data[self::KEY_WATCH_COUNT])) {
            return;
        }
        if (!is_int($data[self::KEY_WATCH_COUNT])) {
            return;
        }
        $itemSummary->setWatchCount($data[self::KEY_WATCH_COUNT]);
    }
}
