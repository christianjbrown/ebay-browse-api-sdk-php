<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemInterface;

use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function sprintf;
use function strtotime;

final class ItemTransformer implements ItemTransformerInterface
{
    private ConvertedAmountTransformerInterface $convertedAmountTransformer;
    private ErrorsTransformerInterface $errorsTransformer;
    private EstimatedAvailabilitiesTransformerInterface $estimatedAvailabilitiesTransformer;
    private ImagesTransformerInterface $imagesTransformer;
    private ImageTransformerInterface $imageTransformer;
    private ItemLocationTransformerInterface $itemLocationTransformer;
    private MarketingPriceTransformerInterface $marketingPriceTransformer;
    private PaymentMethodsTransformerInterface $paymentMethodsTransformer;
    private ProductTransformerInterface $productTransformer;
    private ReturnTermsTransformerInterface $returnTermsTransformer;
    private SellerTransformerInterface $sellerTransformer;
    private ShippingOptionsTransformerInterface $shippingOptionsTransformer;
    private ShipToLocationsTransformerInterface $shipToLocationsTransformer;
    private StringsTransformerInterface $stringsTransformer;
    private TypedNameValuesTransformerInterface $typedNameValuesTransformer;

    public function __construct(ConvertedAmountTransformerInterface $convertedAmountTransformer, ErrorsTransformerInterface $errorsTransformer, EstimatedAvailabilitiesTransformerInterface $estimatedAvailabilitiesTransformer, ImageTransformerInterface $imageTransformer, ImagesTransformerInterface $imagesTransformer, ItemLocationTransformerInterface $itemLocationTransformer, MarketingPriceTransformerInterface $marketingPriceTransformer, PaymentMethodsTransformerInterface $paymentMethodsTransformer, ProductTransformerInterface $productTransformer, ReturnTermsTransformerInterface $returnTermsTransformer, SellerTransformerInterface $sellerTransformer, ShipToLocationsTransformerInterface $shipToLocationsTransformer, ShippingOptionsTransformerInterface $shippingOptionsTransformer, StringsTransformerInterface $stringsTransformer, TypedNameValuesTransformerInterface $typedNameValuesTransformer)
    {
        $this->convertedAmountTransformer = $convertedAmountTransformer;
        $this->errorsTransformer = $errorsTransformer;
        $this->estimatedAvailabilitiesTransformer = $estimatedAvailabilitiesTransformer;
        $this->imageTransformer = $imageTransformer;
        $this->imagesTransformer = $imagesTransformer;
        $this->itemLocationTransformer = $itemLocationTransformer;
        $this->marketingPriceTransformer = $marketingPriceTransformer;
        $this->paymentMethodsTransformer = $paymentMethodsTransformer;
        $this->productTransformer = $productTransformer;
        $this->returnTermsTransformer = $returnTermsTransformer;
        $this->sellerTransformer = $sellerTransformer;
        $this->shipToLocationsTransformer = $shipToLocationsTransformer;
        $this->shippingOptionsTransformer = $shippingOptionsTransformer;
        $this->stringsTransformer = $stringsTransformer;
        $this->typedNameValuesTransformer = $typedNameValuesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ItemInterface
    {
        if (empty($data[self::KEY_ITEM_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ITEM_ID));
        }
        if (!is_string($data[self::KEY_ITEM_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ITEM_ID));
        }
        $item = new Item($data[self::KEY_ITEM_ID]);

        $this->applyAdditionalImages($item, $data);
        self::applyAdultOnly($item, $data);
        self::applyAgeGroup($item, $data);
        self::applyBidCount($item, $data);
        self::applyBrand($item, $data);
        $this->applyBuyingOptions($item, $data);
        self::applyCategoryId($item, $data);
        self::applyCategoryIdPath($item, $data);
        self::applyCategoryPath($item, $data);
        self::applyColor($item, $data);
        self::applyCondition($item, $data);
        self::applyConditionDescription($item, $data);
        self::applyConditionId($item, $data);
        $this->applyCurrentBidPrice($item, $data);
        self::applyDescription($item, $data);
        self::applyEligibleForInlineCheckout($item, $data);
        self::applyEnabledForGuestCheckout($item, $data);
        self::applyEnergyEfficiencyClass($item, $data);
        self::applyEpid($item, $data);
        $this->applyEstimatedAvailabilities($item, $data);
        self::applyGtin($item, $data);
        $this->applyImage($item, $data);
        self::applyImmediatePay($item, $data);
        self::applyItemAffiliateWebUrl($item, $data);
        self::applyItemCreationDate($item, $data);
        self::applyItemEndDate($item, $data);
        $this->applyItemLocation($item, $data);
        self::applyItemWebUrl($item, $data);
        self::applyLegacyItemId($item, $data);
        self::applyListingMarketplaceId($item, $data);
        $this->applyLocalizedAspects($item, $data);
        self::applyLotSize($item, $data);
        $this->applyMarketingPrice($item, $data);
        self::applyMaterial($item, $data);
        self::applyMpn($item, $data);
        $this->applyPaymentMethods($item, $data);
        $this->applyPrice($item, $data);
        self::applyPriorityListing($item, $data);
        $this->applyProduct($item, $data);
        $this->applyReturnTerms($item, $data);
        $this->applySeller($item, $data);
        self::applySellerItemRevision($item, $data);
        $this->applyShipToLocations($item, $data);
        $this->applyShippingOptions($item, $data);
        self::applyShortDescription($item, $data);
        self::applySubtitle($item, $data);
        self::applyTitle($item, $data);
        self::applyTopRatedBuyingExperience($item, $data);
        self::applyUniqueBidderCount($item, $data);
        $this->applyUnitPrice($item, $data);
        self::applyUnitPricingMeasure($item, $data);
        $this->applyWarnings($item, $data);

        return $item;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAdditionalImages(Item $item, array $data): void
    {
        if (empty($data[self::KEY_ADDITIONAL_IMAGES])) {
            return;
        }
        if (!is_array($data[self::KEY_ADDITIONAL_IMAGES])) {
            return;
        }
        $item->setAdditionalImages($this->imagesTransformer->transform($data[self::KEY_ADDITIONAL_IMAGES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAdultOnly(Item $item, array $data): void
    {
        if (!isset($data[self::KEY_ADULT_ONLY])) {
            return;
        }
        if (!is_bool($data[self::KEY_ADULT_ONLY])) {
            return;
        }
        $item->setAdultOnly($data[self::KEY_ADULT_ONLY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyAgeGroup(Item $item, array $data): void
    {
        if (empty($data[self::KEY_AGE_GROUP])) {
            return;
        }
        if (!is_string($data[self::KEY_AGE_GROUP])) {
            return;
        }
        $item->setAgeGroup($data[self::KEY_AGE_GROUP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBidCount(Item $item, array $data): void
    {
        if (!isset($data[self::KEY_BID_COUNT])) {
            return;
        }
        if (!is_int($data[self::KEY_BID_COUNT])) {
            return;
        }
        $item->setBidCount($data[self::KEY_BID_COUNT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyBrand(Item $item, array $data): void
    {
        if (empty($data[self::KEY_BRAND])) {
            return;
        }
        if (!is_string($data[self::KEY_BRAND])) {
            return;
        }
        $item->setBrand($data[self::KEY_BRAND]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBuyingOptions(Item $item, array $data): void
    {
        if (empty($data[self::KEY_BUYING_OPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_BUYING_OPTIONS])) {
            return;
        }
        $item->setBuyingOptions($this->stringsTransformer->transform($data[self::KEY_BUYING_OPTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCategoryId(Item $item, array $data): void
    {
        if (empty($data[self::KEY_CATEGORY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CATEGORY_ID])) {
            return;
        }
        $item->setCategoryId($data[self::KEY_CATEGORY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCategoryIdPath(Item $item, array $data): void
    {
        if (empty($data[self::KEY_CATEGORY_ID_PATH])) {
            return;
        }
        if (!is_string($data[self::KEY_CATEGORY_ID_PATH])) {
            return;
        }
        $item->setCategoryIdPath($data[self::KEY_CATEGORY_ID_PATH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCategoryPath(Item $item, array $data): void
    {
        if (empty($data[self::KEY_CATEGORY_PATH])) {
            return;
        }
        if (!is_string($data[self::KEY_CATEGORY_PATH])) {
            return;
        }
        $item->setCategoryPath($data[self::KEY_CATEGORY_PATH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyColor(Item $item, array $data): void
    {
        if (empty($data[self::KEY_COLOR])) {
            return;
        }
        if (!is_string($data[self::KEY_COLOR])) {
            return;
        }
        $item->setColor($data[self::KEY_COLOR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCondition(Item $item, array $data): void
    {
        if (empty($data[self::KEY_CONDITION])) {
            return;
        }
        if (!is_string($data[self::KEY_CONDITION])) {
            return;
        }
        $item->setCondition($data[self::KEY_CONDITION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionDescription(Item $item, array $data): void
    {
        if (empty($data[self::KEY_CONDITION_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_CONDITION_DESCRIPTION])) {
            return;
        }
        $item->setConditionDescription($data[self::KEY_CONDITION_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyConditionId(Item $item, array $data): void
    {
        if (empty($data[self::KEY_CONDITION_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_CONDITION_ID])) {
            return;
        }
        $item->setConditionId($data[self::KEY_CONDITION_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCurrentBidPrice(Item $item, array $data): void
    {
        if (empty($data[self::KEY_CURRENT_BID_PRICE])) {
            return;
        }
        if (!is_array($data[self::KEY_CURRENT_BID_PRICE])) {
            return;
        }
        $item->setCurrentBidPrice($this->convertedAmountTransformer->transform($data[self::KEY_CURRENT_BID_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(Item $item, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $item->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEligibleForInlineCheckout(Item $item, array $data): void
    {
        if (!isset($data[self::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT])) {
            return;
        }
        if (!is_bool($data[self::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT])) {
            return;
        }
        $item->setEligibleForInlineCheckout($data[self::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEnabledForGuestCheckout(Item $item, array $data): void
    {
        if (!isset($data[self::KEY_ENABLED_FOR_GUEST_CHECKOUT])) {
            return;
        }
        if (!is_bool($data[self::KEY_ENABLED_FOR_GUEST_CHECKOUT])) {
            return;
        }
        $item->setEnabledForGuestCheckout($data[self::KEY_ENABLED_FOR_GUEST_CHECKOUT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEnergyEfficiencyClass(Item $item, array $data): void
    {
        if (empty($data[self::KEY_ENERGY_EFFICIENCY_CLASS])) {
            return;
        }
        if (!is_string($data[self::KEY_ENERGY_EFFICIENCY_CLASS])) {
            return;
        }
        $item->setEnergyEfficiencyClass($data[self::KEY_ENERGY_EFFICIENCY_CLASS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEpid(Item $item, array $data): void
    {
        if (empty($data[self::KEY_EPID])) {
            return;
        }
        if (!is_string($data[self::KEY_EPID])) {
            return;
        }
        $item->setEpid($data[self::KEY_EPID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEstimatedAvailabilities(Item $item, array $data): void
    {
        if (empty($data[self::KEY_ESTIMATED_AVAILABILITIES])) {
            return;
        }
        if (!is_array($data[self::KEY_ESTIMATED_AVAILABILITIES])) {
            return;
        }
        $item->setEstimatedAvailabilities($this->estimatedAvailabilitiesTransformer->transform($data[self::KEY_ESTIMATED_AVAILABILITIES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyGtin(Item $item, array $data): void
    {
        if (empty($data[self::KEY_GTIN])) {
            return;
        }
        if (!is_string($data[self::KEY_GTIN])) {
            return;
        }
        $item->setGtin($data[self::KEY_GTIN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyImage(Item $item, array $data): void
    {
        if (empty($data[self::KEY_IMAGE])) {
            return;
        }
        if (!is_array($data[self::KEY_IMAGE])) {
            return;
        }
        $item->setImage($this->imageTransformer->transform($data[self::KEY_IMAGE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyImmediatePay(Item $item, array $data): void
    {
        if (!isset($data[self::KEY_IMMEDIATE_PAY])) {
            return;
        }
        if (!is_bool($data[self::KEY_IMMEDIATE_PAY])) {
            return;
        }
        $item->setImmediatePay($data[self::KEY_IMMEDIATE_PAY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemAffiliateWebUrl(Item $item, array $data): void
    {
        if (empty($data[self::KEY_ITEM_AFFILIATE_WEB_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_AFFILIATE_WEB_URL])) {
            return;
        }
        $item->setItemAffiliateWebUrl($data[self::KEY_ITEM_AFFILIATE_WEB_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemCreationDate(Item $item, array $data): void
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
        $item->setItemCreationDate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemEndDate(Item $item, array $data): void
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
        $item->setItemEndDate($timestamp);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyItemLocation(Item $item, array $data): void
    {
        if (empty($data[self::KEY_ITEM_LOCATION])) {
            return;
        }
        if (!is_array($data[self::KEY_ITEM_LOCATION])) {
            return;
        }
        $item->setItemLocation($this->itemLocationTransformer->transform($data[self::KEY_ITEM_LOCATION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyItemWebUrl(Item $item, array $data): void
    {
        if (empty($data[self::KEY_ITEM_WEB_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ITEM_WEB_URL])) {
            return;
        }
        $item->setItemWebUrl($data[self::KEY_ITEM_WEB_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLegacyItemId(Item $item, array $data): void
    {
        if (empty($data[self::KEY_LEGACY_ITEM_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LEGACY_ITEM_ID])) {
            return;
        }
        $item->setLegacyItemId($data[self::KEY_LEGACY_ITEM_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyListingMarketplaceId(Item $item, array $data): void
    {
        if (empty($data[self::KEY_LISTING_MARKETPLACE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_LISTING_MARKETPLACE_ID])) {
            return;
        }
        $item->setListingMarketplaceId($data[self::KEY_LISTING_MARKETPLACE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLocalizedAspects(Item $item, array $data): void
    {
        if (empty($data[self::KEY_LOCALIZED_ASPECTS])) {
            return;
        }
        if (!is_array($data[self::KEY_LOCALIZED_ASPECTS])) {
            return;
        }
        $item->setLocalizedAspects($this->typedNameValuesTransformer->transform($data[self::KEY_LOCALIZED_ASPECTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLotSize(Item $item, array $data): void
    {
        if (!isset($data[self::KEY_LOT_SIZE])) {
            return;
        }
        if (!is_int($data[self::KEY_LOT_SIZE])) {
            return;
        }
        $item->setLotSize($data[self::KEY_LOT_SIZE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMarketingPrice(Item $item, array $data): void
    {
        if (empty($data[self::KEY_MARKETING_PRICE])) {
            return;
        }
        if (!is_array($data[self::KEY_MARKETING_PRICE])) {
            return;
        }
        $item->setMarketingPrice($this->marketingPriceTransformer->transform($data[self::KEY_MARKETING_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMaterial(Item $item, array $data): void
    {
        if (empty($data[self::KEY_MATERIAL])) {
            return;
        }
        if (!is_string($data[self::KEY_MATERIAL])) {
            return;
        }
        $item->setMaterial($data[self::KEY_MATERIAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMpn(Item $item, array $data): void
    {
        if (empty($data[self::KEY_MPN])) {
            return;
        }
        if (!is_string($data[self::KEY_MPN])) {
            return;
        }
        $item->setMpn($data[self::KEY_MPN]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPaymentMethods(Item $item, array $data): void
    {
        if (empty($data[self::KEY_PAYMENT_METHODS])) {
            return;
        }
        if (!is_array($data[self::KEY_PAYMENT_METHODS])) {
            return;
        }
        $item->setPaymentMethods($this->paymentMethodsTransformer->transform($data[self::KEY_PAYMENT_METHODS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPrice(Item $item, array $data): void
    {
        if (empty($data[self::KEY_PRICE])) {
            return;
        }
        if (!is_array($data[self::KEY_PRICE])) {
            return;
        }
        $item->setPrice($this->convertedAmountTransformer->transform($data[self::KEY_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPriorityListing(Item $item, array $data): void
    {
        if (!isset($data[self::KEY_PRIORITY_LISTING])) {
            return;
        }
        if (!is_bool($data[self::KEY_PRIORITY_LISTING])) {
            return;
        }
        $item->setPriorityListing($data[self::KEY_PRIORITY_LISTING]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProduct(Item $item, array $data): void
    {
        if (empty($data[self::KEY_PRODUCT])) {
            return;
        }
        if (!is_array($data[self::KEY_PRODUCT])) {
            return;
        }
        $item->setProduct($this->productTransformer->transform($data[self::KEY_PRODUCT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyReturnTerms(Item $item, array $data): void
    {
        if (empty($data[self::KEY_RETURN_TERMS])) {
            return;
        }
        if (!is_array($data[self::KEY_RETURN_TERMS])) {
            return;
        }
        $item->setReturnTerms($this->returnTermsTransformer->transform($data[self::KEY_RETURN_TERMS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySeller(Item $item, array $data): void
    {
        if (empty($data[self::KEY_SELLER])) {
            return;
        }
        if (!is_array($data[self::KEY_SELLER])) {
            return;
        }
        $item->setSeller($this->sellerTransformer->transform($data[self::KEY_SELLER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySellerItemRevision(Item $item, array $data): void
    {
        if (empty($data[self::KEY_SELLER_ITEM_REVISION])) {
            return;
        }
        if (!is_string($data[self::KEY_SELLER_ITEM_REVISION])) {
            return;
        }
        $item->setSellerItemRevision($data[self::KEY_SELLER_ITEM_REVISION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShippingOptions(Item $item, array $data): void
    {
        if (empty($data[self::KEY_SHIPPING_OPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_SHIPPING_OPTIONS])) {
            return;
        }
        $item->setShippingOptions($this->shippingOptionsTransformer->transform($data[self::KEY_SHIPPING_OPTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyShipToLocations(Item $item, array $data): void
    {
        if (empty($data[self::KEY_SHIP_TO_LOCATIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_SHIP_TO_LOCATIONS])) {
            return;
        }
        $item->setShipToLocations($this->shipToLocationsTransformer->transform($data[self::KEY_SHIP_TO_LOCATIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyShortDescription(Item $item, array $data): void
    {
        if (empty($data[self::KEY_SHORT_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_SHORT_DESCRIPTION])) {
            return;
        }
        $item->setShortDescription($data[self::KEY_SHORT_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySubtitle(Item $item, array $data): void
    {
        if (empty($data[self::KEY_SUBTITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_SUBTITLE])) {
            return;
        }
        $item->setSubtitle($data[self::KEY_SUBTITLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTitle(Item $item, array $data): void
    {
        if (empty($data[self::KEY_TITLE])) {
            return;
        }
        if (!is_string($data[self::KEY_TITLE])) {
            return;
        }
        $item->setTitle($data[self::KEY_TITLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyTopRatedBuyingExperience(Item $item, array $data): void
    {
        if (!isset($data[self::KEY_TOP_RATED_BUYING_EXPERIENCE])) {
            return;
        }
        if (!is_bool($data[self::KEY_TOP_RATED_BUYING_EXPERIENCE])) {
            return;
        }
        $item->setTopRatedBuyingExperience($data[self::KEY_TOP_RATED_BUYING_EXPERIENCE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUniqueBidderCount(Item $item, array $data): void
    {
        if (!isset($data[self::KEY_UNIQUE_BIDDER_COUNT])) {
            return;
        }
        if (!is_int($data[self::KEY_UNIQUE_BIDDER_COUNT])) {
            return;
        }
        $item->setUniqueBidderCount($data[self::KEY_UNIQUE_BIDDER_COUNT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyUnitPrice(Item $item, array $data): void
    {
        if (empty($data[self::KEY_UNIT_PRICE])) {
            return;
        }
        if (!is_array($data[self::KEY_UNIT_PRICE])) {
            return;
        }
        $item->setUnitPrice($this->convertedAmountTransformer->transform($data[self::KEY_UNIT_PRICE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnitPricingMeasure(Item $item, array $data): void
    {
        if (empty($data[self::KEY_UNIT_PRICING_MEASURE])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIT_PRICING_MEASURE])) {
            return;
        }
        $item->setUnitPricingMeasure($data[self::KEY_UNIT_PRICING_MEASURE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyWarnings(Item $item, array $data): void
    {
        if (empty($data[self::KEY_WARNINGS])) {
            return;
        }
        if (!is_array($data[self::KEY_WARNINGS])) {
            return;
        }
        $item->setWarnings($this->errorsTransformer->transform($data[self::KEY_WARNINGS]));
    }
}
