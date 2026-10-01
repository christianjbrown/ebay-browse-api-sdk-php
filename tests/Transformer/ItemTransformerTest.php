<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Transformer;

use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Model\AddonServiceInterface;
use ChristianBrown\EBay\Browse\Model\AuthenticityGuaranteeProgramInterface;
use ChristianBrown\EBay\Browse\Model\AuthenticityVerificationProgramInterface;
use ChristianBrown\EBay\Browse\Model\AvailableCouponInterface;
use ChristianBrown\EBay\Browse\Model\CompanyAddressInterface;
use ChristianBrown\EBay\Browse\Model\ConditionDescriptorInterface;
use ChristianBrown\EBay\Browse\Model\ConvertedAmountInterface;
use ChristianBrown\EBay\Browse\Model\ErrorInterface;
use ChristianBrown\EBay\Browse\Model\EstimatedAvailabilityInterface;
use ChristianBrown\EBay\Browse\Model\HazardousMaterialsLabelsInterface;
use ChristianBrown\EBay\Browse\Model\ImageInterface;
use ChristianBrown\EBay\Browse\Model\Item;
use ChristianBrown\EBay\Browse\Model\ItemCharityTermsInterface;
use ChristianBrown\EBay\Browse\Model\ItemGroupSummaryInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ItemLocationInterface;
use ChristianBrown\EBay\Browse\Model\MarketingPriceInterface;
use ChristianBrown\EBay\Browse\Model\PaymentMethodInterface;
use ChristianBrown\EBay\Browse\Model\ProductInterface;
use ChristianBrown\EBay\Browse\Model\ProductSafetyLabelsInterface;
use ChristianBrown\EBay\Browse\Model\ResponsiblePersonInterface;
use ChristianBrown\EBay\Browse\Model\ReturnTermsInterface;
use ChristianBrown\EBay\Browse\Model\ReviewRatingInterface;
use ChristianBrown\EBay\Browse\Model\SellerCustomPolicyInterface;
use ChristianBrown\EBay\Browse\Model\SellerInterface;
use ChristianBrown\EBay\Browse\Model\ShippingOptionInterface;
use ChristianBrown\EBay\Browse\Model\ShipToLocationsInterface;
use ChristianBrown\EBay\Browse\Model\TaxInterface;
use ChristianBrown\EBay\Browse\Model\TypedNameValueInterface;
use ChristianBrown\EBay\Browse\Transformer\AddonServicesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityGuaranteeProgramTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityVerificationProgramTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\CompanyAddressTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilitiesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\HazardousMaterialsLabelsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemCharityTermsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemComplianceTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemConditionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemDescriptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemFulfilmentTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupSummaryTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemListingTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemMediaTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemPricingTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemProductTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\MarketingPriceTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ProductTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ReturnTermsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ReviewRatingTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPoliciesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\SellerTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TaxesTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformerInterface;
use Closure;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Item::class)]
#[CoversClass(ItemDescriptionTransformer::class)]
#[CoversClass(ItemConditionTransformer::class)]
#[CoversClass(ItemMediaTransformer::class)]
#[CoversClass(ItemPricingTransformer::class)]
#[CoversClass(ItemFulfilmentTransformer::class)]
#[CoversClass(ItemListingTransformer::class)]
#[CoversClass(ItemProductTransformer::class)]
#[CoversClass(ItemComplianceTransformer::class)]
#[CoversClass(ItemTransformer::class)]
final class ItemTransformerTest extends TestCase
{
    private ?AddonServiceInterface $addonService = null;
    private ?AuthenticityGuaranteeProgramInterface $authenticityGuaranteeProgram = null;
    private ?AuthenticityVerificationProgramInterface $authenticityVerificationProgram = null;
    private ?AvailableCouponInterface $availableCoupon = null;
    private ?CompanyAddressInterface $companyAddress = null;
    private ?ConditionDescriptorInterface $conditionDescriptor = null;
    private ?ConvertedAmountInterface $convertedAmount = null;
    private ?ErrorInterface $error = null;
    private ?EstimatedAvailabilityInterface $estimatedAvailability = null;
    private ?HazardousMaterialsLabelsInterface $hazardousMaterialsLabels = null;
    private ?ImageInterface $image = null;
    private ?ItemCharityTermsInterface $itemCharityTerms = null;
    private ?ItemGroupSummaryInterface $itemGroupSummary = null;
    private ?ItemLocationInterface $itemLocation = null;
    private ?MarketingPriceInterface $marketingPrice = null;
    private ?PaymentMethodInterface $paymentMethod = null;
    private ?ProductInterface $product = null;
    private ?ProductSafetyLabelsInterface $productSafetyLabels = null;
    private ?ResponsiblePersonInterface $responsiblePerson = null;
    private ?ReturnTermsInterface $returnTerms = null;
    private ?ReviewRatingInterface $reviewRating = null;
    private ?SellerInterface $seller = null;
    private ?SellerCustomPolicyInterface $sellerCustomPolicy = null;
    private ?ShippingOptionInterface $shippingOption = null;
    private ?ShipToLocationsInterface $shipToLocations = null;
    private ?TaxInterface $tax = null;
    private ?TypedNameValueInterface $typedNameValue = null;

    public function testTransform(): void
    {
        $data = [
            ItemTransformerInterface::KEY_ITEM_ID => 'v_0',
            ItemTransformerInterface::KEY_ADDITIONAL_IMAGES => ['raw_additionalImages'],
            ItemTransformerInterface::KEY_ADDON_SERVICES => ['raw_addonServices'],
            ItemTransformerInterface::KEY_ADULT_ONLY => true,
            ItemTransformerInterface::KEY_AGE_GROUP => 'v_1',
            ItemTransformerInterface::KEY_AUTHENTICITY_GUARANTEE => ['raw_authenticityGuarantee'],
            ItemTransformerInterface::KEY_AUTHENTICITY_VERIFICATION => ['raw_authenticityVerification'],
            ItemTransformerInterface::KEY_AVAILABLE_COUPONS => ['raw_availableCoupons'],
            ItemTransformerInterface::KEY_BID_COUNT => 102,
            ItemTransformerInterface::KEY_BRAND => 'v_3',
            ItemTransformerInterface::KEY_BUYING_OPTIONS => ['raw_buyingOptions'],
            ItemTransformerInterface::KEY_CATEGORY_ID => 'v_4',
            ItemTransformerInterface::KEY_CATEGORY_ID_PATH => 'v_5',
            ItemTransformerInterface::KEY_CATEGORY_PATH => 'v_6',
            ItemTransformerInterface::KEY_CHARITY_TERMS => ['raw_charityTerms'],
            ItemTransformerInterface::KEY_COLOR => 'v_7',
            ItemTransformerInterface::KEY_CONDITION => 'v_8',
            ItemTransformerInterface::KEY_CONDITION_DESCRIPTION => 'v_9',
            ItemTransformerInterface::KEY_CONDITION_DESCRIPTORS => ['raw_conditionDescriptors'],
            ItemTransformerInterface::KEY_CONDITION_ID => 'v_10',
            ItemTransformerInterface::KEY_CURRENT_BID_PRICE => ['raw_currentBidPrice'],
            ItemTransformerInterface::KEY_DESCRIPTION => 'v_11',
            ItemTransformerInterface::KEY_ECO_PARTICIPATION_FEE => ['raw_ecoParticipationFee'],
            ItemTransformerInterface::KEY_ELIGIBLE_FOR_INLINE_CHECKOUT => true,
            ItemTransformerInterface::KEY_ENABLED_FOR_GUEST_CHECKOUT => true,
            ItemTransformerInterface::KEY_ENERGY_EFFICIENCY_CLASS => 'v_12',
            ItemTransformerInterface::KEY_EPID => 'v_13',
            ItemTransformerInterface::KEY_ESTIMATED_AVAILABILITIES => ['raw_estimatedAvailabilities'],
            ItemTransformerInterface::KEY_GENDER => 'v_14',
            ItemTransformerInterface::KEY_GTIN => 'v_15',
            ItemTransformerInterface::KEY_HAZARDOUS_MATERIALS_LABELS => ['raw_hazardousMaterialsLabels'],
            ItemTransformerInterface::KEY_IMAGE => ['raw_image'],
            ItemTransformerInterface::KEY_IMMEDIATE_PAY => true,
            ItemTransformerInterface::KEY_INFERRED_EPID => 'v_16',
            ItemTransformerInterface::KEY_ITEM_AFFILIATE_WEB_URL => 'v_17',
            ItemTransformerInterface::KEY_ITEM_CREATION_DATE => '2024-01-02T03:04:05.000Z',
            ItemTransformerInterface::KEY_ITEM_END_DATE => '2024-01-02T03:04:05.000Z',
            ItemTransformerInterface::KEY_ITEM_LOCATION => ['raw_itemLocation'],
            ItemTransformerInterface::KEY_ITEM_WEB_URL => 'v_18',
            ItemTransformerInterface::KEY_LEGACY_ITEM_ID => 'v_19',
            ItemTransformerInterface::KEY_LISTING_MARKETPLACE_ID => 'v_20',
            ItemTransformerInterface::KEY_LOCALIZED_ASPECTS => ['raw_localizedAspects'],
            ItemTransformerInterface::KEY_LOT_SIZE => 121,
            ItemTransformerInterface::KEY_MANUFACTURER => ['raw_manufacturer'],
            ItemTransformerInterface::KEY_MARKETING_PRICE => ['raw_marketingPrice'],
            ItemTransformerInterface::KEY_MATERIAL => 'v_22',
            ItemTransformerInterface::KEY_MINIMUM_PRICE_TO_BID => ['raw_minimumPriceToBid'],
            ItemTransformerInterface::KEY_MPN => 'v_23',
            ItemTransformerInterface::KEY_PATTERN => 'v_24',
            ItemTransformerInterface::KEY_PAYMENT_METHODS => ['raw_paymentMethods'],
            ItemTransformerInterface::KEY_PRICE => ['raw_price'],
            ItemTransformerInterface::KEY_PRICE_DISPLAY_CONDITION => 'v_25',
            ItemTransformerInterface::KEY_PRIMARY_ITEM_GROUP => ['raw_primaryItemGroup'],
            ItemTransformerInterface::KEY_PRIMARY_PRODUCT_REVIEW_RATING => ['raw_primaryProductReviewRating'],
            ItemTransformerInterface::KEY_PRIORITY_LISTING => true,
            ItemTransformerInterface::KEY_PRODUCT => ['raw_product'],
            ItemTransformerInterface::KEY_PRODUCT_FICHE_WEB_URL => 'v_26',
            ItemTransformerInterface::KEY_PRODUCT_SAFETY_LABELS => ['raw_productSafetyLabels'],
            ItemTransformerInterface::KEY_QUALIFIED_PROGRAMS => ['raw_qualifiedPrograms'],
            ItemTransformerInterface::KEY_QUANTITY_LIMIT_PER_BUYER => 127,
            ItemTransformerInterface::KEY_REPAIR_SCORE => 'v_28',
            ItemTransformerInterface::KEY_RESERVE_PRICE_MET => true,
            ItemTransformerInterface::KEY_RESPONSIBLE_PERSONS => ['raw_responsiblePersons'],
            ItemTransformerInterface::KEY_RETURN_TERMS => ['raw_returnTerms'],
            ItemTransformerInterface::KEY_SELLER => ['raw_seller'],
            ItemTransformerInterface::KEY_SELLER_CUSTOM_POLICIES => ['raw_sellerCustomPolicies'],
            ItemTransformerInterface::KEY_SELLER_ITEM_REVISION => 'v_29',
            ItemTransformerInterface::KEY_SHIPPING_OPTIONS => ['raw_shippingOptions'],
            ItemTransformerInterface::KEY_SHIP_TO_LOCATIONS => ['raw_shipToLocations'],
            ItemTransformerInterface::KEY_SHORT_DESCRIPTION => 'v_30',
            ItemTransformerInterface::KEY_SIZE => 'v_31',
            ItemTransformerInterface::KEY_SIZE_SYSTEM => 'v_32',
            ItemTransformerInterface::KEY_SIZE_TYPE => 'v_33',
            ItemTransformerInterface::KEY_SUBTITLE => 'v_34',
            ItemTransformerInterface::KEY_TAXES => ['raw_taxes'],
            ItemTransformerInterface::KEY_TITLE => 'v_35',
            ItemTransformerInterface::KEY_TOP_RATED_BUYING_EXPERIENCE => true,
            ItemTransformerInterface::KEY_TYRE_LABEL_IMAGE_URL => 'v_36',
            ItemTransformerInterface::KEY_UNIQUE_BIDDER_COUNT => 137,
            ItemTransformerInterface::KEY_UNIT_PRICE => ['raw_unitPrice'],
            ItemTransformerInterface::KEY_UNIT_PRICING_MEASURE => 'v_38',
            ItemTransformerInterface::KEY_WARNINGS => ['raw_warnings'],
            ItemTransformerInterface::KEY_WATCH_COUNT => 139,
        ];

        $transformer = $this->buildTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('v_0', $actual->getItemId());
        self::assertSame([$this->image], $actual->getAdditionalImages());
        self::assertSame([$this->addonService], $actual->getAddonServices());
        self::assertTrue($actual->getAdultOnly());
        self::assertSame('v_1', $actual->getAgeGroup());
        self::assertSame($this->authenticityGuaranteeProgram, $actual->getAuthenticityGuarantee());
        self::assertSame($this->authenticityVerificationProgram, $actual->getAuthenticityVerification());
        self::assertSame([$this->availableCoupon], $actual->getAvailableCoupons());
        self::assertSame(102, $actual->getBidCount());
        self::assertSame('v_3', $actual->getBrand());
        self::assertSame(['s'], $actual->getBuyingOptions());
        self::assertSame('v_4', $actual->getCategoryId());
        self::assertSame('v_5', $actual->getCategoryIdPath());
        self::assertSame('v_6', $actual->getCategoryPath());
        self::assertSame($this->itemCharityTerms, $actual->getCharityTerms());
        self::assertSame('v_7', $actual->getColor());
        self::assertSame('v_8', $actual->getCondition());
        self::assertSame('v_9', $actual->getConditionDescription());
        self::assertSame([$this->conditionDescriptor], $actual->getConditionDescriptors());
        self::assertSame('v_10', $actual->getConditionId());
        self::assertSame($this->convertedAmount, $actual->getCurrentBidPrice());
        self::assertSame('v_11', $actual->getDescription());
        self::assertSame($this->convertedAmount, $actual->getEcoParticipationFee());
        self::assertTrue($actual->getEligibleForInlineCheckout());
        self::assertTrue($actual->getEnabledForGuestCheckout());
        self::assertSame('v_12', $actual->getEnergyEfficiencyClass());
        self::assertSame('v_13', $actual->getEpid());
        self::assertSame([$this->estimatedAvailability], $actual->getEstimatedAvailabilities());
        self::assertSame('v_14', $actual->getGender());
        self::assertSame('v_15', $actual->getGtin());
        self::assertSame($this->hazardousMaterialsLabels, $actual->getHazardousMaterialsLabels());
        self::assertSame($this->image, $actual->getImage());
        self::assertTrue($actual->getImmediatePay());
        self::assertSame('v_16', $actual->getInferredEpid());
        self::assertSame('v_17', $actual->getItemAffiliateWebUrl());
        self::assertSame(1704164645, $actual->getItemCreationDate());
        self::assertSame(1704164645, $actual->getItemEndDate());
        self::assertSame($this->itemLocation, $actual->getItemLocation());
        self::assertSame('v_18', $actual->getItemWebUrl());
        self::assertSame('v_19', $actual->getLegacyItemId());
        self::assertSame('v_20', $actual->getListingMarketplaceId());
        self::assertSame([$this->typedNameValue], $actual->getLocalizedAspects());
        self::assertSame(121, $actual->getLotSize());
        self::assertSame($this->companyAddress, $actual->getManufacturer());
        self::assertSame($this->marketingPrice, $actual->getMarketingPrice());
        self::assertSame('v_22', $actual->getMaterial());
        self::assertSame($this->convertedAmount, $actual->getMinimumPriceToBid());
        self::assertSame('v_23', $actual->getMpn());
        self::assertSame('v_24', $actual->getPattern());
        self::assertSame([$this->paymentMethod], $actual->getPaymentMethods());
        self::assertSame($this->convertedAmount, $actual->getPrice());
        self::assertSame('v_25', $actual->getPriceDisplayCondition());
        self::assertSame($this->itemGroupSummary, $actual->getPrimaryItemGroup());
        self::assertSame($this->reviewRating, $actual->getPrimaryProductReviewRating());
        self::assertTrue($actual->getPriorityListing());
        self::assertSame($this->product, $actual->getProduct());
        self::assertSame('v_26', $actual->getProductFicheWebUrl());
        self::assertSame($this->productSafetyLabels, $actual->getProductSafetyLabels());
        self::assertSame(['s'], $actual->getQualifiedPrograms());
        self::assertSame(127, $actual->getQuantityLimitPerBuyer());
        self::assertSame('v_28', $actual->getRepairScore());
        self::assertTrue($actual->getReservePriceMet());
        self::assertSame([$this->responsiblePerson], $actual->getResponsiblePersons());
        self::assertSame($this->returnTerms, $actual->getReturnTerms());
        self::assertSame($this->seller, $actual->getSeller());
        self::assertSame([$this->sellerCustomPolicy], $actual->getSellerCustomPolicies());
        self::assertSame('v_29', $actual->getSellerItemRevision());
        self::assertSame([$this->shippingOption], $actual->getShippingOptions());
        self::assertSame($this->shipToLocations, $actual->getShipToLocations());
        self::assertSame('v_30', $actual->getShortDescription());
        self::assertSame('v_31', $actual->getSize());
        self::assertSame('v_32', $actual->getSizeSystem());
        self::assertSame('v_33', $actual->getSizeType());
        self::assertSame('v_34', $actual->getSubtitle());
        self::assertSame([$this->tax], $actual->getTaxes());
        self::assertSame('v_35', $actual->getTitle());
        self::assertTrue($actual->getTopRatedBuyingExperience());
        self::assertSame('v_36', $actual->getTyreLabelImageUrl());
        self::assertSame(137, $actual->getUniqueBidderCount());
        self::assertSame($this->convertedAmount, $actual->getUnitPrice());
        self::assertSame('v_38', $actual->getUnitPricingMeasure());
        self::assertSame([$this->error], $actual->getWarnings());
        self::assertSame(139, $actual->getWatchCount());
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
                self::assertSame([], $model->getAddonServices());
                self::assertNull($model->getAdultOnly());
                self::assertNull($model->getAgeGroup());
                self::assertNull($model->getAuthenticityGuarantee());
                self::assertNull($model->getAuthenticityVerification());
                self::assertSame([], $model->getAvailableCoupons());
                self::assertNull($model->getBidCount());
                self::assertNull($model->getBrand());
                self::assertSame([], $model->getBuyingOptions());
                self::assertNull($model->getCategoryId());
                self::assertNull($model->getCategoryIdPath());
                self::assertNull($model->getCategoryPath());
                self::assertNull($model->getCharityTerms());
                self::assertNull($model->getColor());
                self::assertNull($model->getCondition());
                self::assertNull($model->getConditionDescription());
                self::assertSame([], $model->getConditionDescriptors());
                self::assertNull($model->getConditionId());
                self::assertNull($model->getCurrentBidPrice());
                self::assertNull($model->getDescription());
                self::assertNull($model->getEcoParticipationFee());
                self::assertNull($model->getEligibleForInlineCheckout());
                self::assertNull($model->getEnabledForGuestCheckout());
                self::assertNull($model->getEnergyEfficiencyClass());
                self::assertNull($model->getEpid());
                self::assertSame([], $model->getEstimatedAvailabilities());
                self::assertNull($model->getGender());
                self::assertNull($model->getGtin());
                self::assertNull($model->getHazardousMaterialsLabels());
                self::assertNull($model->getImage());
                self::assertNull($model->getImmediatePay());
                self::assertNull($model->getInferredEpid());
                self::assertNull($model->getItemAffiliateWebUrl());
                self::assertNull($model->getItemCreationDate());
                self::assertNull($model->getItemEndDate());
                self::assertNull($model->getItemLocation());
                self::assertNull($model->getItemWebUrl());
                self::assertNull($model->getLegacyItemId());
                self::assertNull($model->getListingMarketplaceId());
                self::assertSame([], $model->getLocalizedAspects());
                self::assertNull($model->getLotSize());
                self::assertNull($model->getManufacturer());
                self::assertNull($model->getMarketingPrice());
                self::assertNull($model->getMaterial());
                self::assertNull($model->getMinimumPriceToBid());
                self::assertNull($model->getMpn());
                self::assertNull($model->getPattern());
                self::assertSame([], $model->getPaymentMethods());
                self::assertNull($model->getPrice());
                self::assertNull($model->getPriceDisplayCondition());
                self::assertNull($model->getPrimaryItemGroup());
                self::assertNull($model->getPrimaryProductReviewRating());
                self::assertNull($model->getPriorityListing());
                self::assertNull($model->getProduct());
                self::assertNull($model->getProductFicheWebUrl());
                self::assertNull($model->getProductSafetyLabels());
                self::assertSame([], $model->getQualifiedPrograms());
                self::assertNull($model->getQuantityLimitPerBuyer());
                self::assertNull($model->getRepairScore());
                self::assertNull($model->getReservePriceMet());
                self::assertSame([], $model->getResponsiblePersons());
                self::assertNull($model->getReturnTerms());
                self::assertNull($model->getSeller());
                self::assertSame([], $model->getSellerCustomPolicies());
                self::assertNull($model->getSellerItemRevision());
                self::assertSame([], $model->getShippingOptions());
                self::assertNull($model->getShipToLocations());
                self::assertNull($model->getShortDescription());
                self::assertNull($model->getSize());
                self::assertNull($model->getSizeSystem());
                self::assertNull($model->getSizeType());
                self::assertNull($model->getSubtitle());
                self::assertSame([], $model->getTaxes());
                self::assertNull($model->getTitle());
                self::assertNull($model->getTopRatedBuyingExperience());
                self::assertNull($model->getTyreLabelImageUrl());
                self::assertNull($model->getUniqueBidderCount());
                self::assertNull($model->getUnitPrice());
                self::assertNull($model->getUnitPricingMeasure());
                self::assertSame([], $model->getWarnings());
                self::assertNull($model->getWatchCount());
            },
        ];

        yield 'additionalImagesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ADDITIONAL_IMAGES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getAdditionalImages());
            },
        ];

        yield 'addonServicesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ADDON_SERVICES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getAddonServices());
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

        yield 'authenticityGuaranteeWrongType' => [
            [...$base, ItemTransformerInterface::KEY_AUTHENTICITY_GUARANTEE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getAuthenticityGuarantee());
            },
        ];

        yield 'authenticityVerificationWrongType' => [
            [...$base, ItemTransformerInterface::KEY_AUTHENTICITY_VERIFICATION => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getAuthenticityVerification());
            },
        ];

        yield 'availableCouponsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_AVAILABLE_COUPONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getAvailableCoupons());
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

        yield 'charityTermsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CHARITY_TERMS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getCharityTerms());
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

        yield 'conditionDescriptorsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_CONDITION_DESCRIPTORS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getConditionDescriptors());
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

        yield 'ecoParticipationFeeWrongType' => [
            [...$base, ItemTransformerInterface::KEY_ECO_PARTICIPATION_FEE => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getEcoParticipationFee());
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

        yield 'genderWrongType' => [
            [...$base, ItemTransformerInterface::KEY_GENDER => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getGender());
            },
        ];

        yield 'gtinWrongType' => [
            [...$base, ItemTransformerInterface::KEY_GTIN => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getGtin());
            },
        ];

        yield 'hazardousMaterialsLabelsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_HAZARDOUS_MATERIALS_LABELS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getHazardousMaterialsLabels());
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

        yield 'inferredEpidWrongType' => [
            [...$base, ItemTransformerInterface::KEY_INFERRED_EPID => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getInferredEpid());
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

        yield 'manufacturerWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MANUFACTURER => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getManufacturer());
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

        yield 'minimumPriceToBidWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MINIMUM_PRICE_TO_BID => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getMinimumPriceToBid());
            },
        ];

        yield 'mpnWrongType' => [
            [...$base, ItemTransformerInterface::KEY_MPN => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getMpn());
            },
        ];

        yield 'patternWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PATTERN => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPattern());
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

        yield 'priceDisplayConditionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRICE_DISPLAY_CONDITION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPriceDisplayCondition());
            },
        ];

        yield 'primaryItemGroupWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRIMARY_ITEM_GROUP => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPrimaryItemGroup());
            },
        ];

        yield 'primaryProductReviewRatingWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRIMARY_PRODUCT_REVIEW_RATING => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getPrimaryProductReviewRating());
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

        yield 'productFicheWebUrlWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRODUCT_FICHE_WEB_URL => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getProductFicheWebUrl());
            },
        ];

        yield 'productSafetyLabelsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_PRODUCT_SAFETY_LABELS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getProductSafetyLabels());
            },
        ];

        yield 'qualifiedProgramsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_QUALIFIED_PROGRAMS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getQualifiedPrograms());
            },
        ];

        yield 'quantityLimitPerBuyerWrongType' => [
            [...$base, ItemTransformerInterface::KEY_QUANTITY_LIMIT_PER_BUYER => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getQuantityLimitPerBuyer());
            },
        ];

        yield 'quantityLimitPerBuyerZero' => [
            [...$base, ItemTransformerInterface::KEY_QUANTITY_LIMIT_PER_BUYER => 0],
            static function (ItemInterface $model): void {
                self::assertSame(0, $model->getQuantityLimitPerBuyer());
            },
        ];

        yield 'repairScoreWrongType' => [
            [...$base, ItemTransformerInterface::KEY_REPAIR_SCORE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getRepairScore());
            },
        ];

        yield 'reservePriceMetWrongType' => [
            [...$base, ItemTransformerInterface::KEY_RESERVE_PRICE_MET => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getReservePriceMet());
            },
        ];

        yield 'reservePriceMetFalse' => [
            [...$base, ItemTransformerInterface::KEY_RESERVE_PRICE_MET => false],
            static function (ItemInterface $model): void {
                self::assertFalse($model->getReservePriceMet());
            },
        ];

        yield 'responsiblePersonsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_RESPONSIBLE_PERSONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getResponsiblePersons());
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

        yield 'sellerCustomPoliciesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SELLER_CUSTOM_POLICIES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getSellerCustomPolicies());
            },
        ];

        yield 'sellerItemRevisionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SELLER_ITEM_REVISION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSellerItemRevision());
            },
        ];

        yield 'shippingOptionsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SHIPPING_OPTIONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getShippingOptions());
            },
        ];

        yield 'shipToLocationsWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SHIP_TO_LOCATIONS => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getShipToLocations());
            },
        ];

        yield 'shortDescriptionWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SHORT_DESCRIPTION => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getShortDescription());
            },
        ];

        yield 'sizeWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SIZE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSize());
            },
        ];

        yield 'sizeSystemWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SIZE_SYSTEM => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSizeSystem());
            },
        ];

        yield 'sizeTypeWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SIZE_TYPE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSizeType());
            },
        ];

        yield 'subtitleWrongType' => [
            [...$base, ItemTransformerInterface::KEY_SUBTITLE => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getSubtitle());
            },
        ];

        yield 'taxesWrongType' => [
            [...$base, ItemTransformerInterface::KEY_TAXES => 'x'],
            static function (ItemInterface $model): void {
                self::assertSame([], $model->getTaxes());
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

        yield 'tyreLabelImageUrlWrongType' => [
            [...$base, ItemTransformerInterface::KEY_TYRE_LABEL_IMAGE_URL => 42],
            static function (ItemInterface $model): void {
                self::assertNull($model->getTyreLabelImageUrl());
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

        yield 'watchCountWrongType' => [
            [...$base, ItemTransformerInterface::KEY_WATCH_COUNT => 'x'],
            static function (ItemInterface $model): void {
                self::assertNull($model->getWatchCount());
            },
        ];

        yield 'watchCountZero' => [
            [...$base, ItemTransformerInterface::KEY_WATCH_COUNT => 0],
            static function (ItemInterface $model): void {
                self::assertSame(0, $model->getWatchCount());
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
        $this->image = self::createStub(ImageInterface::class);
        $this->addonService = self::createStub(AddonServiceInterface::class);
        $this->authenticityGuaranteeProgram = self::createStub(AuthenticityGuaranteeProgramInterface::class);
        $this->authenticityVerificationProgram = self::createStub(AuthenticityVerificationProgramInterface::class);
        $this->availableCoupon = self::createStub(AvailableCouponInterface::class);
        $this->itemCharityTerms = self::createStub(ItemCharityTermsInterface::class);
        $this->conditionDescriptor = self::createStub(ConditionDescriptorInterface::class);
        $this->convertedAmount = self::createStub(ConvertedAmountInterface::class);
        $this->estimatedAvailability = self::createStub(EstimatedAvailabilityInterface::class);
        $this->hazardousMaterialsLabels = self::createStub(HazardousMaterialsLabelsInterface::class);
        $this->itemLocation = self::createStub(ItemLocationInterface::class);
        $this->typedNameValue = self::createStub(TypedNameValueInterface::class);
        $this->companyAddress = self::createStub(CompanyAddressInterface::class);
        $this->marketingPrice = self::createStub(MarketingPriceInterface::class);
        $this->paymentMethod = self::createStub(PaymentMethodInterface::class);
        $this->itemGroupSummary = self::createStub(ItemGroupSummaryInterface::class);
        $this->reviewRating = self::createStub(ReviewRatingInterface::class);
        $this->product = self::createStub(ProductInterface::class);
        $this->productSafetyLabels = self::createStub(ProductSafetyLabelsInterface::class);
        $this->responsiblePerson = self::createStub(ResponsiblePersonInterface::class);
        $this->returnTerms = self::createStub(ReturnTermsInterface::class);
        $this->seller = self::createStub(SellerInterface::class);
        $this->sellerCustomPolicy = self::createStub(SellerCustomPolicyInterface::class);
        $this->shippingOption = self::createStub(ShippingOptionInterface::class);
        $this->shipToLocations = self::createStub(ShipToLocationsInterface::class);
        $this->tax = self::createStub(TaxInterface::class);
        $this->error = self::createStub(ErrorInterface::class);

        $addonServicesTransformer = self::createStub(AddonServicesTransformerInterface::class);
        $addonServicesTransformer->method('transform')->willReturn([$this->addonService]);
        $authenticityGuaranteeProgramTransformer = self::createStub(AuthenticityGuaranteeProgramTransformerInterface::class);
        $authenticityGuaranteeProgramTransformer->method('transform')->willReturn($this->authenticityGuaranteeProgram);
        $authenticityVerificationProgramTransformer = self::createStub(AuthenticityVerificationProgramTransformerInterface::class);
        $authenticityVerificationProgramTransformer->method('transform')->willReturn($this->authenticityVerificationProgram);
        $availableCouponsTransformer = self::createStub(AvailableCouponsTransformerInterface::class);
        $availableCouponsTransformer->method('transform')->willReturn([$this->availableCoupon]);
        $companyAddressTransformer = self::createStub(CompanyAddressTransformerInterface::class);
        $companyAddressTransformer->method('transform')->willReturn($this->companyAddress);
        $conditionDescriptorsTransformer = self::createStub(ConditionDescriptorsTransformerInterface::class);
        $conditionDescriptorsTransformer->method('transform')->willReturn([$this->conditionDescriptor]);
        $convertedAmountTransformer = self::createStub(ConvertedAmountTransformerInterface::class);
        $convertedAmountTransformer->method('transform')->willReturn($this->convertedAmount);
        $errorsTransformer = self::createStub(ErrorsTransformerInterface::class);
        $errorsTransformer->method('transform')->willReturn([$this->error]);
        $estimatedAvailabilitiesTransformer = self::createStub(EstimatedAvailabilitiesTransformerInterface::class);
        $estimatedAvailabilitiesTransformer->method('transform')->willReturn([$this->estimatedAvailability]);
        $hazardousMaterialsLabelsTransformer = self::createStub(HazardousMaterialsLabelsTransformerInterface::class);
        $hazardousMaterialsLabelsTransformer->method('transform')->willReturn($this->hazardousMaterialsLabels);
        $imageTransformer = self::createStub(ImageTransformerInterface::class);
        $imageTransformer->method('transform')->willReturn($this->image);
        $imagesTransformer = self::createStub(ImagesTransformerInterface::class);
        $imagesTransformer->method('transform')->willReturn([$this->image]);
        $itemCharityTermsTransformer = self::createStub(ItemCharityTermsTransformerInterface::class);
        $itemCharityTermsTransformer->method('transform')->willReturn($this->itemCharityTerms);
        $itemGroupSummaryTransformer = self::createStub(ItemGroupSummaryTransformerInterface::class);
        $itemGroupSummaryTransformer->method('transform')->willReturn($this->itemGroupSummary);
        $itemLocationTransformer = self::createStub(ItemLocationTransformerInterface::class);
        $itemLocationTransformer->method('transform')->willReturn($this->itemLocation);
        $marketingPriceTransformer = self::createStub(MarketingPriceTransformerInterface::class);
        $marketingPriceTransformer->method('transform')->willReturn($this->marketingPrice);
        $paymentMethodsTransformer = self::createStub(PaymentMethodsTransformerInterface::class);
        $paymentMethodsTransformer->method('transform')->willReturn([$this->paymentMethod]);
        $productSafetyLabelsTransformer = self::createStub(ProductSafetyLabelsTransformerInterface::class);
        $productSafetyLabelsTransformer->method('transform')->willReturn($this->productSafetyLabels);
        $productTransformer = self::createStub(ProductTransformerInterface::class);
        $productTransformer->method('transform')->willReturn($this->product);
        $responsiblePersonsTransformer = self::createStub(ResponsiblePersonsTransformerInterface::class);
        $responsiblePersonsTransformer->method('transform')->willReturn([$this->responsiblePerson]);
        $returnTermsTransformer = self::createStub(ReturnTermsTransformerInterface::class);
        $returnTermsTransformer->method('transform')->willReturn($this->returnTerms);
        $reviewRatingTransformer = self::createStub(ReviewRatingTransformerInterface::class);
        $reviewRatingTransformer->method('transform')->willReturn($this->reviewRating);
        $sellerCustomPoliciesTransformer = self::createStub(SellerCustomPoliciesTransformerInterface::class);
        $sellerCustomPoliciesTransformer->method('transform')->willReturn([$this->sellerCustomPolicy]);
        $sellerTransformer = self::createStub(SellerTransformerInterface::class);
        $sellerTransformer->method('transform')->willReturn($this->seller);
        $shipToLocationsTransformer = self::createStub(ShipToLocationsTransformerInterface::class);
        $shipToLocationsTransformer->method('transform')->willReturn($this->shipToLocations);
        $shippingOptionsTransformer = self::createStub(ShippingOptionsTransformerInterface::class);
        $shippingOptionsTransformer->method('transform')->willReturn([$this->shippingOption]);
        $stringsTransformer = self::createStub(StringsTransformerInterface::class);
        $stringsTransformer->method('transform')->willReturn(['s']);
        $taxesTransformer = self::createStub(TaxesTransformerInterface::class);
        $taxesTransformer->method('transform')->willReturn([$this->tax]);
        $typedNameValuesTransformer = self::createStub(TypedNameValuesTransformerInterface::class);
        $typedNameValuesTransformer->method('transform')->willReturn([$this->typedNameValue]);

        return new ItemTransformer(
            new ItemDescriptionTransformer($typedNameValuesTransformer),
            new ItemConditionTransformer($conditionDescriptorsTransformer),
            new ItemMediaTransformer($imageTransformer, $imagesTransformer),
            new ItemPricingTransformer($availableCouponsTransformer, $convertedAmountTransformer, $marketingPriceTransformer, $paymentMethodsTransformer, $stringsTransformer, $taxesTransformer),
            new ItemFulfilmentTransformer($addonServicesTransformer, $estimatedAvailabilitiesTransformer, $itemLocationTransformer, $returnTermsTransformer, $shipToLocationsTransformer, $shippingOptionsTransformer),
            new ItemListingTransformer($authenticityGuaranteeProgramTransformer, $authenticityVerificationProgramTransformer, $itemCharityTermsTransformer, $sellerCustomPoliciesTransformer, $sellerTransformer, $stringsTransformer),
            new ItemProductTransformer($itemGroupSummaryTransformer, $productTransformer, $reviewRatingTransformer),
            new ItemComplianceTransformer($companyAddressTransformer, $errorsTransformer, $hazardousMaterialsLabelsTransformer, $productSafetyLabelsTransformer, $responsiblePersonsTransformer),
        );
    }
}
