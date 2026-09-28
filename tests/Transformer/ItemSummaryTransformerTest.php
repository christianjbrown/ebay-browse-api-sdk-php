<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\CategoryInterface;
use ChristianBrown\EBay\Browse\Model\CompatibilityPropertyInterface;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\ItemLocationInterface;
use ChristianBrown\EBay\Browse\Model\ItemSummary;
use ChristianBrown\EBay\Browse\Model\ItemSummaryInterface;
use ChristianBrown\EBay\Browse\Model\MarketingPriceInterface;
use ChristianBrown\EBay\Browse\Model\PickupOptionSummaryInterface;
use ChristianBrown\EBay\Browse\Model\SellerInterface;
use ChristianBrown\EBay\Browse\Model\ShippingOptionInterface;
use ChristianBrown\EBay\Browse\Model\TargetLocationInterface;
use ChristianBrown\EBay\Browse\Transformer\CategoriesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityPropertiesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemSummaryTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\MarketingPriceTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\PickupOptionSummariesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TargetLocationTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ItemSummary::class)]
#[CoversClass(ItemSummaryTransformer::class)]
final class ItemSummaryTransformerTest extends TestCase
{
    private ?CategoryInterface $category = null;
    private ?CompatibilityPropertyInterface $compatibilityProperty = null;
    private ?ConvertedAmountInterface $convertedAmount = null;
    private ?ImageInterface $image = null;
    private ?ItemLocationInterface $itemLocation = null;
    private ?MarketingPriceInterface $marketingPrice = null;
    private ?PickupOptionSummaryInterface $pickupOptionSummary = null;
    private ?SellerInterface $seller = null;
    private ?ShippingOptionInterface $shippingOption = null;
    private ?TargetLocationInterface $targetLocation = null;

    public function testTransform(): void
    {
        $data = [
            ItemSummaryTransformerInterface::KEY_ITEM_ID => 'v_0',
            ItemSummaryTransformerInterface::KEY_ADDITIONAL_IMAGES => ['raw_additionalImages'],
            ItemSummaryTransformerInterface::KEY_ADULT_ONLY => true,
            ItemSummaryTransformerInterface::KEY_AVAILABLE_COUPONS => true,
            ItemSummaryTransformerInterface::KEY_BID_COUNT => 101,
            ItemSummaryTransformerInterface::KEY_BUYING_OPTIONS => ['raw_buyingOptions'],
            ItemSummaryTransformerInterface::KEY_CATEGORIES => ['raw_categories'],
            ItemSummaryTransformerInterface::KEY_COMPATIBILITY_MATCH => 'v_2',
            ItemSummaryTransformerInterface::KEY_COMPATIBILITY_PROPERTIES => ['raw_compatibilityProperties'],
            ItemSummaryTransformerInterface::KEY_CONDITION => 'v_3',
            ItemSummaryTransformerInterface::KEY_CONDITION_ID => 'v_4',
            ItemSummaryTransformerInterface::KEY_CURRENT_BID_PRICE => ['raw_currentBidPrice'],
            ItemSummaryTransformerInterface::KEY_DISTANCE_FROM_PICKUP_LOCATION => ['raw_distanceFromPickupLocation'],
            ItemSummaryTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS => 'v_5',
            ItemSummaryTransformerInterface::KEY_EPID => 'v_6',
            ItemSummaryTransformerInterface::KEY_IMAGE => ['raw_image'],
            ItemSummaryTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL => 'v_7',
            ItemSummaryTransformerInterface::KEY_ITEM_CREATION_DATE => '2024-01-02T03:04:05.000Z',
            ItemSummaryTransformerInterface::KEY_ITEM_END_DATE => '2024-01-02T03:04:05.000Z',
            ItemSummaryTransformerInterface::KEY_ITEM_GROUP_HREF => 'v_8',
            ItemSummaryTransformerInterface::KEY_ITEM_GROUP_TYPE => 'v_9',
            ItemSummaryTransformerInterface::KEY_ITEM_HREF => 'v_10',
            ItemSummaryTransformerInterface::KEY_ITEM_LOCATION => ['raw_itemLocation'],
            ItemSummaryTransformerInterface::KEY_ITEM_ORIGIN_DATE => '2024-01-02T03:04:05.000Z',
            ItemSummaryTransformerInterface::KEY_ITEM_WEB_URL => 'v_11',
            ItemSummaryTransformerInterface::KEY_LEAF_CATEGORY_IDS => ['raw_leafCategoryIds'],
            ItemSummaryTransformerInterface::KEY_LEGACY_ITEM_ID => 'v_12',
            ItemSummaryTransformerInterface::KEY_LISTING_MARKETPLACE_ID => 'v_13',
            ItemSummaryTransformerInterface::KEY_MARKETING_PRICE => ['raw_marketingPrice'],
            ItemSummaryTransformerInterface::KEY_PICKUP_OPTIONS => ['raw_pickupOptions'],
            ItemSummaryTransformerInterface::KEY_PRICE => ['raw_price'],
            ItemSummaryTransformerInterface::KEY_PRICE_DISPLAY_CONDITION => 'v_14',
            ItemSummaryTransformerInterface::KEY_PRIORITY_LISTING => true,
            ItemSummaryTransformerInterface::KEY_QUALIFIED_PROGRAMS => ['raw_qualifiedPrograms'],
            ItemSummaryTransformerInterface::KEY_SELLER => ['raw_seller'],
            ItemSummaryTransformerInterface::KEY_SHIPPING_OPTIONS => ['raw_shippingOptions'],
            ItemSummaryTransformerInterface::KEY_SHORT_DESCRIPTION => 'v_15',
            ItemSummaryTransformerInterface::KEY_THUMBNAIL_IMAGES => ['raw_thumbnailImages'],
            ItemSummaryTransformerInterface::KEY_TITLE => 'v_16',
            ItemSummaryTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => true,
            ItemSummaryTransformerInterface::KEY_TYRE_LABEL_IMAGE_URL => 'v_17',
            ItemSummaryTransformerInterface::KEY_UNIT_PRICE => ['raw_unitPrice'],
            ItemSummaryTransformerInterface::KEY_UNIT_PRICING_MEASURE => 'v_18',
            ItemSummaryTransformerInterface::KEY_WATCH_COUNT => 119,
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getItemId());
        self::assertSame([$this->image], $actual->getAdditionalImages());
        self::assertTrue($actual->getAdultOnly());
        self::assertTrue($actual->getAvailableCoupons());
        self::assertSame(101, $actual->getBidCount());
        self::assertSame(['s'], $actual->getBuyingOptions());
        self::assertSame([$this->category], $actual->getCategories());
        self::assertSame('v_2', $actual->getCompatibilityMatch());
        self::assertSame([$this->compatibilityProperty], $actual->getCompatibilityProperties());
        self::assertSame('v_3', $actual->getCondition());
        self::assertSame('v_4', $actual->getConditionId());
        self::assertSame($this->convertedAmount, $actual->getCurrentBidPrice());
        self::assertSame($this->targetLocation, $actual->getDistanceFromPickupLocation());
        self::assertSame('v_5', $actual->getEnergyEfficiencyClass());
        self::assertSame('v_6', $actual->getEpid());
        self::assertSame($this->image, $actual->getImage());
        self::assertSame('v_7', $actual->getItemAffiliateWebUrl());
        self::assertSame(1704164645, $actual->getItemCreationDate());
        self::assertSame(1704164645, $actual->getItemEndDate());
        self::assertSame('v_8', $actual->getItemGroupHref());
        self::assertSame('v_9', $actual->getItemGroupType());
        self::assertSame('v_10', $actual->getItemHref());
        self::assertSame($this->itemLocation, $actual->getItemLocation());
        self::assertSame(1704164645, $actual->getItemOriginDate());
        self::assertSame('v_11', $actual->getItemWebUrl());
        self::assertSame(['s'], $actual->getLeafCategoryIds());
        self::assertSame('v_12', $actual->getLegacyItemId());
        self::assertSame('v_13', $actual->getListingMarketplaceId());
        self::assertSame($this->marketingPrice, $actual->getMarketingPrice());
        self::assertSame([$this->pickupOptionSummary], $actual->getPickupOptions());
        self::assertSame($this->convertedAmount, $actual->getPrice());
        self::assertSame('v_14', $actual->getPriceDisplayCondition());
        self::assertTrue($actual->getPriorityListing());
        self::assertSame(['s'], $actual->getQualifiedPrograms());
        self::assertSame($this->seller, $actual->getSeller());
        self::assertSame([$this->shippingOption], $actual->getShippingOptions());
        self::assertSame('v_15', $actual->getShortDescription());
        self::assertSame([$this->image], $actual->getThumbnailImages());
        self::assertSame('v_16', $actual->getTitle());
        self::assertTrue($actual->getTopRatedBuyingExperience());
        self::assertSame('v_17', $actual->getTyreLabelImageUrl());
        self::assertSame($this->convertedAmount, $actual->getUnitPrice());
        self::assertSame('v_18', $actual->getUnitPricingMeasure());
        self::assertSame(119, $actual->getWatchCount());
    }

    /**
     * @param array<string, mixed>                $data
     * @param Closure(ItemSummaryInterface): void $assert
     */
    #[DataProvider('provideTransformOptionalFieldStatesCases')]
    public function testTransformOptionalFieldStates(array $data, Closure $assert): void
    {
        $transformer = $this->buildTransformer();

        $assert($transformer->transform($data));
    }

    /**
     * @return iterable<string, array{array<string, mixed>, Closure(ItemSummaryInterface): void}>
     */
    public static function provideTransformOptionalFieldStatesCases(): iterable
    {
        $base = [ItemSummaryTransformerInterface::KEY_ITEM_ID => 'v_0'];

        yield 'allOptionalAbsent' => [
            $base,
            static function (ItemSummaryInterface $model): void {
                self::assertSame([], $model->getAdditionalImages());
                self::assertNull($model->getAdultOnly());
                self::assertNull($model->getAvailableCoupons());
                self::assertNull($model->getBidCount());
                self::assertSame([], $model->getBuyingOptions());
                self::assertSame([], $model->getCategories());
                self::assertNull($model->getCompatibilityMatch());
                self::assertSame([], $model->getCompatibilityProperties());
                self::assertNull($model->getCondition());
                self::assertNull($model->getConditionId());
                self::assertNull($model->getCurrentBidPrice());
                self::assertNull($model->getDistanceFromPickupLocation());
                self::assertNull($model->getEnergyEfficiencyClass());
                self::assertNull($model->getEpid());
                self::assertNull($model->getImage());
                self::assertNull($model->getItemAffiliateWebUrl());
                self::assertNull($model->getItemCreationDate());
                self::assertNull($model->getItemEndDate());
                self::assertNull($model->getItemGroupHref());
                self::assertNull($model->getItemGroupType());
                self::assertNull($model->getItemHref());
                self::assertNull($model->getItemLocation());
                self::assertNull($model->getItemOriginDate());
                self::assertNull($model->getItemWebUrl());
                self::assertSame([], $model->getLeafCategoryIds());
                self::assertNull($model->getLegacyItemId());
                self::assertNull($model->getListingMarketplaceId());
                self::assertNull($model->getMarketingPrice());
                self::assertSame([], $model->getPickupOptions());
                self::assertNull($model->getPrice());
                self::assertNull($model->getPriceDisplayCondition());
                self::assertNull($model->getPriorityListing());
                self::assertSame([], $model->getQualifiedPrograms());
                self::assertNull($model->getSeller());
                self::assertSame([], $model->getShippingOptions());
                self::assertNull($model->getShortDescription());
                self::assertSame([], $model->getThumbnailImages());
                self::assertNull($model->getTitle());
                self::assertNull($model->getTopRatedBuyingExperience());
                self::assertNull($model->getTyreLabelImageUrl());
                self::assertNull($model->getUnitPrice());
                self::assertNull($model->getUnitPricingMeasure());
                self::assertNull($model->getWatchCount());
            },
        ];

        yield 'additionalImagesWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ADDITIONAL_IMAGES => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertSame([], $model->getAdditionalImages());
            },
        ];

        yield 'adultOnlyWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ADULT_ONLY => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getAdultOnly());
            },
        ];

        yield 'adultOnlyFalse' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ADULT_ONLY => false],
            static function (ItemSummaryInterface $model): void {
                self::assertFalse($model->getAdultOnly());
            },
        ];

        yield 'availableCouponsWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_AVAILABLE_COUPONS => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getAvailableCoupons());
            },
        ];

        yield 'availableCouponsFalse' => [
            [...$base, ItemSummaryTransformerInterface::KEY_AVAILABLE_COUPONS => false],
            static function (ItemSummaryInterface $model): void {
                self::assertFalse($model->getAvailableCoupons());
            },
        ];

        yield 'bidCountWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_BID_COUNT => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getBidCount());
            },
        ];

        yield 'bidCountZero' => [
            [...$base, ItemSummaryTransformerInterface::KEY_BID_COUNT => 0],
            static function (ItemSummaryInterface $model): void {
                self::assertSame(0, $model->getBidCount());
            },
        ];

        yield 'buyingOptionsWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_BUYING_OPTIONS => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertSame([], $model->getBuyingOptions());
            },
        ];

        yield 'categoriesWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_CATEGORIES => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertSame([], $model->getCategories());
            },
        ];

        yield 'compatibilityMatchWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_COMPATIBILITY_MATCH => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getCompatibilityMatch());
            },
        ];

        yield 'compatibilityPropertiesWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_COMPATIBILITY_PROPERTIES => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertSame([], $model->getCompatibilityProperties());
            },
        ];

        yield 'conditionWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_CONDITION => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getCondition());
            },
        ];

        yield 'conditionIdWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_CONDITION_ID => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getConditionId());
            },
        ];

        yield 'currentBidPriceWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_CURRENT_BID_PRICE => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getCurrentBidPrice());
            },
        ];

        yield 'distanceFromPickupLocationWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_DISTANCE_FROM_PICKUP_LOCATION => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getDistanceFromPickupLocation());
            },
        ];

        yield 'energyEfficiencyClassWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getEnergyEfficiencyClass());
            },
        ];

        yield 'epidWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_EPID => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getEpid());
            },
        ];

        yield 'imageWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_IMAGE => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getImage());
            },
        ];

        yield 'itemAffiliateWebUrlWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemAffiliateWebUrl());
            },
        ];

        yield 'itemCreationDateWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_CREATION_DATE => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemCreationDate());
            },
        ];

        yield 'itemCreationDateUnparseable' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_CREATION_DATE => 'not-a-date'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemCreationDate());
            },
        ];

        yield 'itemEndDateWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_END_DATE => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemEndDate());
            },
        ];

        yield 'itemEndDateUnparseable' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_END_DATE => 'not-a-date'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemEndDate());
            },
        ];

        yield 'itemGroupHrefWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_GROUP_HREF => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemGroupHref());
            },
        ];

        yield 'itemGroupTypeWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_GROUP_TYPE => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemGroupType());
            },
        ];

        yield 'itemHrefWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_HREF => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemHref());
            },
        ];

        yield 'itemLocationWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_LOCATION => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemLocation());
            },
        ];

        yield 'itemOriginDateWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_ORIGIN_DATE => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemOriginDate());
            },
        ];

        yield 'itemOriginDateUnparseable' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_ORIGIN_DATE => 'not-a-date'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemOriginDate());
            },
        ];

        yield 'itemWebUrlWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_ITEM_WEB_URL => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getItemWebUrl());
            },
        ];

        yield 'leafCategoryIdsWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_LEAF_CATEGORY_IDS => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertSame([], $model->getLeafCategoryIds());
            },
        ];

        yield 'legacyItemIdWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_LEGACY_ITEM_ID => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getLegacyItemId());
            },
        ];

        yield 'listingMarketplaceIdWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_LISTING_MARKETPLACE_ID => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getListingMarketplaceId());
            },
        ];

        yield 'marketingPriceWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_MARKETING_PRICE => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getMarketingPrice());
            },
        ];

        yield 'pickupOptionsWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_PICKUP_OPTIONS => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertSame([], $model->getPickupOptions());
            },
        ];

        yield 'priceWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_PRICE => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getPrice());
            },
        ];

        yield 'priceDisplayConditionWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_PRICE_DISPLAY_CONDITION => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getPriceDisplayCondition());
            },
        ];

        yield 'priorityListingWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_PRIORITY_LISTING => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getPriorityListing());
            },
        ];

        yield 'priorityListingFalse' => [
            [...$base, ItemSummaryTransformerInterface::KEY_PRIORITY_LISTING => false],
            static function (ItemSummaryInterface $model): void {
                self::assertFalse($model->getPriorityListing());
            },
        ];

        yield 'qualifiedProgramsWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_QUALIFIED_PROGRAMS => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertSame([], $model->getQualifiedPrograms());
            },
        ];

        yield 'sellerWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_SELLER => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getSeller());
            },
        ];

        yield 'shippingOptionsWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_SHIPPING_OPTIONS => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertSame([], $model->getShippingOptions());
            },
        ];

        yield 'shortDescriptionWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_SHORT_DESCRIPTION => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getShortDescription());
            },
        ];

        yield 'thumbnailImagesWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_THUMBNAIL_IMAGES => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertSame([], $model->getThumbnailImages());
            },
        ];

        yield 'titleWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_TITLE => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getTitle());
            },
        ];

        yield 'topRatedBuyingExperienceWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getTopRatedBuyingExperience());
            },
        ];

        yield 'topRatedBuyingExperienceFalse' => [
            [...$base, ItemSummaryTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => false],
            static function (ItemSummaryInterface $model): void {
                self::assertFalse($model->getTopRatedBuyingExperience());
            },
        ];

        yield 'tyreLabelImageUrlWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_TYRE_LABEL_IMAGE_URL => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getTyreLabelImageUrl());
            },
        ];

        yield 'unitPriceWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_UNIT_PRICE => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getUnitPrice());
            },
        ];

        yield 'unitPricingMeasureWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_UNIT_PRICING_MEASURE => 42],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getUnitPricingMeasure());
            },
        ];

        yield 'watchCountWrongType' => [
            [...$base, ItemSummaryTransformerInterface::KEY_WATCH_COUNT => 'x'],
            static function (ItemSummaryInterface $model): void {
                self::assertNull($model->getWatchCount());
            },
        ];

        yield 'watchCountZero' => [
            [...$base, ItemSummaryTransformerInterface::KEY_WATCH_COUNT => 0],
            static function (ItemSummaryInterface $model): void {
                self::assertSame(0, $model->getWatchCount());
            },
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[ItemSummaryTransformerInterface::KEY_ITEM_ID => 42]])]
    public function testTransformThrowsOnInvalidItemId(array $data): void
    {
        $transformer = $this->buildTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ItemSummaryTransformerInterface::UNEXPECTED_STRING_SPRINTF, ItemSummaryTransformerInterface::KEY_ITEM_ID));

        $transformer->transform($data);
    }

    private function buildTransformer(): ItemSummaryTransformer
    {
        $this->image = self::createStub(ImageInterface::class);
        $this->category = self::createStub(CategoryInterface::class);
        $this->compatibilityProperty = self::createStub(CompatibilityPropertyInterface::class);
        $this->convertedAmount = self::createStub(ConvertedAmountInterface::class);
        $this->targetLocation = self::createStub(TargetLocationInterface::class);
        $this->itemLocation = self::createStub(ItemLocationInterface::class);
        $this->marketingPrice = self::createStub(MarketingPriceInterface::class);
        $this->pickupOptionSummary = self::createStub(PickupOptionSummaryInterface::class);
        $this->seller = self::createStub(SellerInterface::class);
        $this->shippingOption = self::createStub(ShippingOptionInterface::class);

        $categoriesTransformer = self::createStub(CategoriesTransformerInterface::class);
        $categoriesTransformer->method('transform')->willReturn([$this->category]);
        $compatibilityPropertiesTransformer = self::createStub(CompatibilityPropertiesTransformerInterface::class);
        $compatibilityPropertiesTransformer->method('transform')->willReturn([$this->compatibilityProperty]);
        $convertedAmountTransformer = self::createStub(ConvertedAmountTransformerInterface::class);
        $convertedAmountTransformer->method('transform')->willReturn($this->convertedAmount);
        $imageTransformer = self::createStub(ImageTransformerInterface::class);
        $imageTransformer->method('transform')->willReturn($this->image);
        $imagesTransformer = self::createStub(ImagesTransformerInterface::class);
        $imagesTransformer->method('transform')->willReturn([$this->image]);
        $itemLocationTransformer = self::createStub(ItemLocationTransformerInterface::class);
        $itemLocationTransformer->method('transform')->willReturn($this->itemLocation);
        $marketingPriceTransformer = self::createStub(MarketingPriceTransformerInterface::class);
        $marketingPriceTransformer->method('transform')->willReturn($this->marketingPrice);
        $pickupOptionSummariesTransformer = self::createStub(PickupOptionSummariesTransformerInterface::class);
        $pickupOptionSummariesTransformer->method('transform')->willReturn([$this->pickupOptionSummary]);
        $sellerTransformer = self::createStub(SellerTransformerInterface::class);
        $sellerTransformer->method('transform')->willReturn($this->seller);
        $shippingOptionsTransformer = self::createStub(ShippingOptionsTransformerInterface::class);
        $shippingOptionsTransformer->method('transform')->willReturn([$this->shippingOption]);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);
        $targetLocationTransformer = self::createStub(TargetLocationTransformerInterface::class);
        $targetLocationTransformer->method('transform')->willReturn($this->targetLocation);

        return new ItemSummaryTransformer($categoriesTransformer, $compatibilityPropertiesTransformer, $convertedAmountTransformer, $imageTransformer, $imagesTransformer, $itemLocationTransformer, $marketingPriceTransformer, $pickupOptionSummariesTransformer, $sellerTransformer, $shippingOptionsTransformer, $stringsTransformer, $targetLocationTransformer);
    }
}
