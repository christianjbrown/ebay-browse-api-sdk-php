<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\EstimatedAvailabilityInterface;
use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ItemLocationInterface;
use ChristianBrown\EBay\Browse\Model\MarketingPriceInterface;
use ChristianBrown\EBay\Browse\Model\PaymentMethodInterface;
use ChristianBrown\EBay\Browse\Model\ProductInterface;
use ChristianBrown\EBay\Browse\Model\ReturnTermsInterface;
use ChristianBrown\EBay\Browse\Model\SellerInterface;
use ChristianBrown\EBay\Browse\Model\ShippingOptionInterface;
use ChristianBrown\EBay\Browse\Model\ShipToLocationsInterface;
use ChristianBrown\EBay\Browse\Model\TypedNameValueInterface;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilitiesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\MarketingPriceTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ReturnTermsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Item::class)]
#[CoversClass(ItemTransformer::class)]
final class ItemTransformerTest extends TestCase
{
    private ?ConvertedAmountInterface $convertedAmount = null;
    private ?ErrorInterface $error = null;
    private ?EstimatedAvailabilityInterface $estimatedAvailability = null;
    private ?ImageInterface $image = null;
    private ?ItemLocationInterface $itemLocation = null;
    private ?MarketingPriceInterface $marketingPrice = null;
    private ?PaymentMethodInterface $paymentMethod = null;
    private ?ProductInterface $product = null;
    private ?ReturnTermsInterface $returnTerms = null;
    private ?SellerInterface $seller = null;
    private ?ShippingOptionInterface $shippingOption = null;
    private ?ShipToLocationsInterface $shipToLocations = null;
    private ?TypedNameValueInterface $typedNameValue = null;

    public function testTransform(): void
    {
        $data = [
            ItemTransformerInterface::KEY_ITEM_ID => 'v_0',
            ItemTransformerInterface::KEY_ADDITIONAL_IMAGES => ['raw_additionalImages'],
            ItemTransformerInterface::KEY_ADULT_ONLY => true,
            ItemTransformerInterface::KEY_AGE_GROUP => 'v_3',
            ItemTransformerInterface::KEY_BID_COUNT => 104,
            ItemTransformerInterface::KEY_BRAND => 'v_5',
            ItemTransformerInterface::KEY_BUYING_OPTIONS => ['raw_buyingOptions'],
            ItemTransformerInterface::KEY_CATEGORY_ID => 'v_7',
            ItemTransformerInterface::KEY_CATEGORY_ID_PATH => 'v_8',
            ItemTransformerInterface::KEY_CATEGORY_PATH => 'v_9',
            ItemTransformerInterface::KEY_COLOR => 'v_10',
            ItemTransformerInterface::KEY_CONDITION => 'v_11',
            ItemTransformerInterface::KEY_CONDITION_DESCRIPTION => 'v_12',
            ItemTransformerInterface::KEY_CONDITION_ID => 'v_13',
            ItemTransformerInterface::KEY_CURRENT_BID_PRICE => ['raw_currentBidPrice'],
            ItemTransformerInterface::KEY_DESCRIPTION => 'v_15',
            ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT => true,
            ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT => true,
            ItemTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS => 'v_18',
            ItemTransformerInterface::KEY_EPID => 'v_19',
            ItemTransformerInterface::KEY_ESTIMATED_AVAILABILITIES => ['raw_estimatedAvailabilities'],
            ItemTransformerInterface::KEY_GTIN => 'v_21',
            ItemTransformerInterface::KEY_IMAGE => ['raw_image'],
            ItemTransformerInterface::KEY_IMMEDIATE_PAY => true,
            ItemTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL => 'v_24',
            ItemTransformerInterface::KEY_ITEM_CREATION_DATE => '2024-01-02T03:04:05.000Z',
            ItemTransformerInterface::KEY_ITEM_END_DATE => '2024-01-02T03:04:05.000Z',
            ItemTransformerInterface::KEY_ITEM_LOCATION => ['raw_itemLocation'],
            ItemTransformerInterface::KEY_ITEM_WEB_URL => 'v_28',
            ItemTransformerInterface::KEY_LEGACY_ITEM_ID => 'v_29',
            ItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID => 'v_30',
            ItemTransformerInterface::KEY_LOCALIZED_ASPECTS => ['raw_localizedAspects'],
            ItemTransformerInterface::KEY_LOT_SIZE => 132,
            ItemTransformerInterface::KEY_MARKETING_PRICE => ['raw_marketingPrice'],
            ItemTransformerInterface::KEY_MATERIAL => 'v_34',
            ItemTransformerInterface::KEY_MPN => 'v_35',
            ItemTransformerInterface::KEY_PAYMENT_METHODS => ['raw_paymentMethods'],
            ItemTransformerInterface::KEY_PRICE => ['raw_price'],
            ItemTransformerInterface::KEY_PRIORITY_LISTING => true,
            ItemTransformerInterface::KEY_PRODUCT => ['raw_product'],
            ItemTransformerInterface::KEY_RETURN_TERMS => ['raw_returnTerms'],
            ItemTransformerInterface::KEY_SELLER => ['raw_seller'],
            ItemTransformerInterface::KEY_SELLER_ITEM_REVISION => 'v_42',
            ItemTransformerInterface::KEY_SHIP_TO_LOCATIONS => ['raw_shipToLocations'],
            ItemTransformerInterface::KEY_SHIPPING_OPTIONS => ['raw_shippingOptions'],
            ItemTransformerInterface::KEY_SHORT_DESCRIPTION => 'v_45',
            ItemTransformerInterface::KEY_SUBTITLE => 'v_46',
            ItemTransformerInterface::KEY_TITLE => 'v_47',
            ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => true,
            ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT => 149,
            ItemTransformerInterface::KEY_UNIT_PRICE => ['raw_unitPrice'],
            ItemTransformerInterface::KEY_UNIT_PRICING_MEASURE => 'v_51',
            ItemTransformerInterface::KEY_WARNINGS => ['raw_warnings'],
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getItemId());
        self::assertSame([$this->image], $actual->getAdditionalImages());
        self::assertTrue($actual->getAdultOnly());
        self::assertSame('v_3', $actual->getAgeGroup());
        self::assertSame(104, $actual->getBidCount());
        self::assertSame('v_5', $actual->getBrand());
        self::assertSame(['s'], $actual->getBuyingOptions());
        self::assertSame('v_7', $actual->getCategoryId());
        self::assertSame('v_8', $actual->getCategoryIdPath());
        self::assertSame('v_9', $actual->getCategoryPath());
        self::assertSame('v_10', $actual->getColor());
        self::assertSame('v_11', $actual->getCondition());
        self::assertSame('v_12', $actual->getConditionDescription());
        self::assertSame('v_13', $actual->getConditionId());
        self::assertSame($this->convertedAmount, $actual->getCurrentBidPrice());
        self::assertSame('v_15', $actual->getDescription());
        self::assertTrue($actual->getEligibleForInlineCheckout());
        self::assertTrue($actual->getEnabledForGuestCheckout());
        self::assertSame('v_18', $actual->getEnergyEfficiencyClass());
        self::assertSame('v_19', $actual->getEpid());
        self::assertSame([$this->estimatedAvailability], $actual->getEstimatedAvailabilities());
        self::assertSame('v_21', $actual->getGtin());
        self::assertSame($this->image, $actual->getImage());
        self::assertTrue($actual->getImmediatePay());
        self::assertSame('v_24', $actual->getItemAffiliateWebUrl());
        self::assertSame(1704164645, $actual->getItemCreationDate());
        self::assertSame(1704164645, $actual->getItemEndDate());
        self::assertSame($this->itemLocation, $actual->getItemLocation());
        self::assertSame('v_28', $actual->getItemWebUrl());
        self::assertSame('v_29', $actual->getLegacyItemId());
        self::assertSame('v_30', $actual->getListingMarketplaceId());
        self::assertSame([$this->typedNameValue], $actual->getLocalizedAspects());
        self::assertSame(132, $actual->getLotSize());
        self::assertSame($this->marketingPrice, $actual->getMarketingPrice());
        self::assertSame('v_34', $actual->getMaterial());
        self::assertSame('v_35', $actual->getMpn());
        self::assertSame([$this->paymentMethod], $actual->getPaymentMethods());
        self::assertSame($this->convertedAmount, $actual->getPrice());
        self::assertTrue($actual->getPriorityListing());
        self::assertSame($this->product, $actual->getProduct());
        self::assertSame($this->returnTerms, $actual->getReturnTerms());
        self::assertSame($this->seller, $actual->getSeller());
        self::assertSame('v_42', $actual->getSellerItemRevision());
        self::assertSame($this->shipToLocations, $actual->getShipToLocations());
        self::assertSame([$this->shippingOption], $actual->getShippingOptions());
        self::assertSame('v_45', $actual->getShortDescription());
        self::assertSame('v_46', $actual->getSubtitle());
        self::assertSame('v_47', $actual->getTitle());
        self::assertTrue($actual->getTopRatedBuyingExperience());
        self::assertSame(149, $actual->getUniqueBidderCount());
        self::assertSame($this->convertedAmount, $actual->getUnitPrice());
        self::assertSame('v_51', $actual->getUnitPricingMeasure());
        self::assertSame([$this->error], $actual->getWarnings());
    }

    /**
     * @param array<string, mixed>         $data
     * @param Closure(ItemInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ItemInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [ItemTransformerInterface::KEY_ITEM_ID => 'v_0'];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getAdditionalImages());
                self::assertNull($model->getAdultOnly());
                self::assertNull($model->getAgeGroup());
                self::assertNull($model->getBidCount());
                self::assertNull($model->getBrand());
                self::assertSame([], $model->getBuyingOptions());
                self::assertNull($model->getCategoryId());
                self::assertNull($model->getCategoryIdPath());
                self::assertNull($model->getCategoryPath());
                self::assertNull($model->getColor());
                self::assertNull($model->getCondition());
                self::assertNull($model->getConditionDescription());
                self::assertNull($model->getConditionId());
                self::assertNull($model->getCurrentBidPrice());
                self::assertNull($model->getDescription());
                self::assertNull($model->getEligibleForInlineCheckout());
                self::assertNull($model->getEnabledForGuestCheckout());
                self::assertNull($model->getEnergyEfficiencyClass());
                self::assertNull($model->getEpid());
                self::assertSame([], $model->getEstimatedAvailabilities());
                self::assertNull($model->getGtin());
                self::assertNull($model->getImage());
                self::assertNull($model->getImmediatePay());
                self::assertNull($model->getItemAffiliateWebUrl());
                self::assertNull($model->getItemCreationDate());
                self::assertNull($model->getItemEndDate());
                self::assertNull($model->getItemLocation());
                self::assertNull($model->getItemWebUrl());
                self::assertNull($model->getLegacyItemId());
                self::assertNull($model->getListingMarketplaceId());
                self::assertSame([], $model->getLocalizedAspects());
                self::assertNull($model->getLotSize());
                self::assertNull($model->getMarketingPrice());
                self::assertNull($model->getMaterial());
                self::assertNull($model->getMpn());
                self::assertSame([], $model->getPaymentMethods());
                self::assertNull($model->getPrice());
                self::assertNull($model->getPriorityListing());
                self::assertNull($model->getProduct());
                self::assertNull($model->getReturnTerms());
                self::assertNull($model->getSeller());
                self::assertNull($model->getSellerItemRevision());
                self::assertNull($model->getShipToLocations());
                self::assertSame([], $model->getShippingOptions());
                self::assertNull($model->getShortDescription());
                self::assertNull($model->getSubtitle());
                self::assertNull($model->getTitle());
                self::assertNull($model->getTopRatedBuyingExperience());
                self::assertNull($model->getUniqueBidderCount());
                self::assertNull($model->getUnitPrice());
                self::assertNull($model->getUnitPricingMeasure());
                self::assertSame([], $model->getWarnings());
            },
        ];

        yield 'additionalImagesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ADDITIONAL_IMAGES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getAdditionalImages());
            },
        ];

        yield 'adultOnlyWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ADULT_ONLY => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getAdultOnly());
            },
        ];

        yield 'adultOnlyFalse' => [
            [...$base, ItemTransformerInterface::KEY_ADULT_ONLY => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getAdultOnly());
            },
        ];

        yield 'ageGroupWrongType' => [
            [...$base, ItemTransformerInterface::KEY_AGE_GROUP => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getAgeGroup());
            },
        ];

        yield 'bidCountWrongType' => [
            [...$base, ItemTransformerInterface::KEY_BID_COUNT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getBidCount());
            },
        ];

        yield 'bidCountZero' => [
            [...$base, ItemTransformerInterface::KEY_BID_COUNT => 0],
            static function (ItemInterface $model): void {
                self::assertSame(0, $model->getBidCount());
            },
        ];

        yield 'brandWrongType' => [
            [...$base, ItemTransformerInterface::KEY_BRAND => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getBrand());
            },
        ];

        yield 'buyingOptionsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_BUYING_OPTIONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getBuyingOptions());
            },
        ];

        yield 'categoryIdWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CATEGORY_ID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCategoryId());
            },
        ];

        yield 'categoryIdPathWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CATEGORY_ID_PATH => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCategoryIdPath());
            },
        ];

        yield 'categoryPathWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CATEGORY_PATH => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCategoryPath());
            },
        ];

        yield 'colorWrongType' => [
            [...$base, ItemTransformerInterface::KEY_COLOR => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getColor());
            },
        ];

        yield 'conditionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CONDITION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCondition());
            },
        ];

        yield 'conditionDescriptionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CONDITION_DESCRIPTION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getConditionDescription());
            },
        ];

        yield 'conditionIdWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CONDITION_ID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getConditionId());
            },
        ];

        yield 'currentBidPriceWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CURRENT_BID_PRICE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCurrentBidPrice());
            },
        ];

        yield 'descriptionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_DESCRIPTION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getDescription());
            },
        ];

        yield 'eligibleForInlineCheckoutWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getEligibleForInlineCheckout());
            },
        ];

        yield 'eligibleForInlineCheckoutFalse' => [
            [...$base, ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getEligibleForInlineCheckout());
            },
        ];

        yield 'enabledForGuestCheckoutWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getEnabledForGuestCheckout());
            },
        ];

        yield 'enabledForGuestCheckoutFalse' => [
            [...$base, ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getEnabledForGuestCheckout());
            },
        ];

        yield 'energyEfficiencyClassWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getEnergyEfficiencyClass());
            },
        ];

        yield 'epidWrongType' => [
            [...$base, ItemTransformerInterface::KEY_EPID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getEpid());
            },
        ];

        yield 'estimatedAvailabilitiesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ESTIMATED_AVAILABILITIES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getEstimatedAvailabilities());
            },
        ];

        yield 'gtinWrongType' => [
            [...$base, ItemTransformerInterface::KEY_GTIN => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getGtin());
            },
        ];

        yield 'imageWrongType' => [
            [...$base, ItemTransformerInterface::KEY_IMAGE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getImage());
            },
        ];

        yield 'immediatePayWrongType' => [
            [...$base, ItemTransformerInterface::KEY_IMMEDIATE_PAY => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getImmediatePay());
            },
        ];

        yield 'immediatePayFalse' => [
            [...$base, ItemTransformerInterface::KEY_IMMEDIATE_PAY => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getImmediatePay());
            },
        ];

        yield 'itemAffiliateWebUrlWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemAffiliateWebUrl());
            },
        ];

        yield 'itemCreationDateWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_CREATION_DATE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemCreationDate());
            },
        ];

        yield 'itemCreationDateUnparseable' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_CREATION_DATE => 'not-a-date'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemCreationDate());
            },
        ];

        yield 'itemEndDateWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_END_DATE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemEndDate());
            },
        ];

        yield 'itemEndDateUnparseable' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_END_DATE => 'not-a-date'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemEndDate());
            },
        ];

        yield 'itemLocationWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_LOCATION => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemLocation());
            },
        ];

        yield 'itemWebUrlWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ITEM_WEB_URL => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getItemWebUrl());
            },
        ];

        yield 'legacyItemIdWrongType' => [
            [...$base, ItemTransformerInterface::KEY_LEGACY_ITEM_ID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getLegacyItemId());
            },
        ];

        yield 'listingMarketplaceIdWrongType' => [
            [...$base, ItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getListingMarketplaceId());
            },
        ];

        yield 'localizedAspectsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_LOCALIZED_ASPECTS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getLocalizedAspects());
            },
        ];

        yield 'lotSizeWrongType' => [
            [...$base, ItemTransformerInterface::KEY_LOT_SIZE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getLotSize());
            },
        ];

        yield 'lotSizeZero' => [
            [...$base, ItemTransformerInterface::KEY_LOT_SIZE => 0],
            static function (ItemInterface $model): void {
                self::assertSame(0, $model->getLotSize());
            },
        ];

        yield 'marketingPriceWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MARKETING_PRICE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getMarketingPrice());
            },
        ];

        yield 'materialWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MATERIAL => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getMaterial());
            },
        ];

        yield 'mpnWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MPN => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getMpn());
            },
        ];

        yield 'paymentMethodsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PAYMENT_METHODS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getPaymentMethods());
            },
        ];

        yield 'priceWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRICE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPrice());
            },
        ];

        yield 'priorityListingWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRIORITY_LISTING => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPriorityListing());
            },
        ];

        yield 'priorityListingFalse' => [
            [...$base, ItemTransformerInterface::KEY_PRIORITY_LISTING => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getPriorityListing());
            },
        ];

        yield 'productWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRODUCT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getProduct());
            },
        ];

        yield 'returnTermsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_RETURN_TERMS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getReturnTerms());
            },
        ];

        yield 'sellerWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SELLER => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSeller());
            },
        ];

        yield 'sellerItemRevisionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SELLER_ITEM_REVISION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSellerItemRevision());
            },
        ];

        yield 'shipToLocationsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SHIP_TO_LOCATIONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getShipToLocations());
            },
        ];

        yield 'shippingOptionsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SHIPPING_OPTIONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getShippingOptions());
            },
        ];

        yield 'shortDescriptionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SHORT_DESCRIPTION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getShortDescription());
            },
        ];

        yield 'subtitleWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SUBTITLE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSubtitle());
            },
        ];

        yield 'titleWrongType' => [
            [...$base, ItemTransformerInterface::KEY_TITLE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getTitle());
            },
        ];

        yield 'topRatedBuyingExperienceWrongType' => [
            [...$base, ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getTopRatedBuyingExperience());
            },
        ];

        yield 'topRatedBuyingExperienceFalse' => [
            [...$base, ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getTopRatedBuyingExperience());
            },
        ];

        yield 'uniqueBidderCountWrongType' => [
            [...$base, ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getUniqueBidderCount());
            },
        ];

        yield 'uniqueBidderCountZero' => [
            [...$base, ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT => 0],
            static function (ItemInterface $model): void {
                self::assertSame(0, $model->getUniqueBidderCount());
            },
        ];

        yield 'unitPriceWrongType' => [
            [...$base, ItemTransformerInterface::KEY_UNIT_PRICE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getUnitPrice());
            },
        ];

        yield 'unitPricingMeasureWrongType' => [
            [...$base, ItemTransformerInterface::KEY_UNIT_PRICING_MEASURE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getUnitPricingMeasure());
            },
        ];

        yield 'warningsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_WARNINGS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getWarnings());
            },
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ItemTransformerInterface::KEY_ITEM_ID => 42]])]
    public function testTransformThrowsOnInvalidItemId(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, ItemTransformerInterface::KEY_ITEM_ID));

        $transformer->transform($data);
    }

    private function buildTransformer(): ItemTransformer
    {
        $this->convertedAmount = self::createStub(ConvertedAmountInterface::class);
        $this->error = self::createStub(ErrorInterface::class);
        $this->estimatedAvailability = self::createStub(EstimatedAvailabilityInterface::class);
        $this->image = self::createStub(ImageInterface::class);
        $this->itemLocation = self::createStub(ItemLocationInterface::class);
        $this->marketingPrice = self::createStub(MarketingPriceInterface::class);
        $this->paymentMethod = self::createStub(PaymentMethodInterface::class);
        $this->product = self::createStub(ProductInterface::class);
        $this->returnTerms = self::createStub(ReturnTermsInterface::class);
        $this->seller = self::createStub(SellerInterface::class);
        $this->shipToLocations = self::createStub(ShipToLocationsInterface::class);
        $this->shippingOption = self::createStub(ShippingOptionInterface::class);
        $this->typedNameValue = self::createStub(TypedNameValueInterface::class);

        $convertedAmountTransformer = self::createStub(ConvertedAmountTransformerInterface::class);
        $convertedAmountTransformer->method('transform')->willReturn($this->convertedAmount);
        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $errorsTransformer->method('transform')->willReturn([$this->error]);
        $estimatedAvailabilitiesTransformer = self::createStub(EstimatedAvailabilitiesTransformerInterface::class);
        $estimatedAvailabilitiesTransformer->method('transform')->willReturn([$this->estimatedAvailability]);
        $imageTransformer = self::createStub(ImageTransformerInterface::class);
        $imageTransformer->method('transform')->willReturn($this->image);
        $imagesTransformer = self::createStub(ImagesTransformerInterface::class);
        $imagesTransformer->method('transform')->willReturn([$this->image]);
        $itemLocationTransformer = self::createStub(ItemLocationTransformerInterface::class);
        $itemLocationTransformer->method('transform')->willReturn($this->itemLocation);
        $marketingPriceTransformer = self::createStub(MarketingPriceTransformerInterface::class);
        $marketingPriceTransformer->method('transform')->willReturn($this->marketingPrice);
        $paymentMethodsTransformer = self::createStub(PaymentMethodsTransformerInterface::class);
        $paymentMethodsTransformer->method('transform')->willReturn([$this->paymentMethod]);
        $productTransformer = self::createStub(ProductTransformerInterface::class);
        $productTransformer->method('transform')->willReturn($this->product);
        $returnTermsTransformer = self::createStub(ReturnTermsTransformerInterface::class);
        $returnTermsTransformer->method('transform')->willReturn($this->returnTerms);
        $sellerTransformer = self::createStub(SellerTransformerInterface::class);
        $sellerTransformer->method('transform')->willReturn($this->seller);
        $shipToLocationsTransformer = self::createStub(ShipToLocationsTransformerInterface::class);
        $shipToLocationsTransformer->method('transform')->willReturn($this->shipToLocations);
        $shippingOptionsTransformer = self::createStub(ShippingOptionsTransformerInterface::class);
        $shippingOptionsTransformer->method('transform')->willReturn([$this->shippingOption]);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);
        $typedNameValuesTransformer = self::createStub(TypedNameValuesTransformerInterface::class);
        $typedNameValuesTransformer->method('transform')->willReturn([$this->typedNameValue]);

        return new ItemTransformer($convertedAmountTransformer, $errorsTransformer, $estimatedAvailabilitiesTransformer, $imageTransformer, $imagesTransformer, $itemLocationTransformer, $marketingPriceTransformer, $paymentMethodsTransformer, $productTransformer, $returnTermsTransformer, $sellerTransformer, $shipToLocationsTransformer, $shippingOptionsTransformer, $stringsTransformer, $typedNameValuesTransformer);
    }
}
