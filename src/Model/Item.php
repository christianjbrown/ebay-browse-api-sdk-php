<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class Item implements ItemInterface
{
    /**
     * @var array<int, ImageInterface>
     */
    private array $additionalImages = [];

    /**
     * @var array<int, AddonServiceInterface>
     */
    private array $addonServices = [];
    private ?bool $adultOnly = null;
    private ?string $ageGroup = null;
    private ?AuthenticityGuaranteeProgramInterface $authenticityGuarantee = null;
    private ?AuthenticityVerificationProgramInterface $authenticityVerification = null;

    /**
     * @var array<int, AvailableCouponInterface>
     */
    private array $availableCoupons = [];
    private ?int $bidCount = null;
    private ?string $brand = null;

    /**
     * @var array<int, string>
     */
    private array $buyingOptions = [];
    private ?string $categoryId = null;
    private ?string $categoryIdPath = null;
    private ?string $categoryPath = null;
    private ?ItemCharityTermsInterface $charityTerms = null;
    private ?string $color = null;
    private ?string $condition = null;
    private ?string $conditionDescription = null;

    /**
     * @var array<int, ConditionDescriptorInterface>
     */
    private array $conditionDescriptors = [];
    private ?string $conditionId = null;
    private ?ConvertedAmountInterface $currentBidPrice = null;
    private ?string $description = null;
    private ?ConvertedAmountInterface $ecoParticipationFee = null;
    private ?bool $eligibleForInlineCheckout = null;
    private ?bool $enabledForGuestCheckout = null;
    private ?string $energyEfficiencyClass = null;
    private ?string $epid = null;

    /**
     * @var array<int, EstimatedAvailabilityInterface>
     */
    private array $estimatedAvailabilities = [];
    private ?string $gender = null;
    private ?string $gtin = null;
    private ?HazardousMaterialsLabelsInterface $hazardousMaterialsLabels = null;
    private ?ImageInterface $image = null;
    private ?bool $immediatePay = null;
    private ?string $inferredEpid = null;
    private ?string $itemAffiliateWebUrl = null;
    private ?int $itemCreationDate = null;
    private ?int $itemEndDate = null;
    private string $itemId;
    private ?ItemLocationInterface $itemLocation = null;
    private ?string $itemWebUrl = null;
    private ?string $legacyItemId = null;
    private ?string $listingMarketplaceId = null;

    /**
     * @var array<int, TypedNameValueInterface>
     */
    private array $localizedAspects = [];
    private ?int $lotSize = null;
    private ?CompanyAddressInterface $manufacturer = null;
    private ?MarketingPriceInterface $marketingPrice = null;
    private ?string $material = null;
    private ?ConvertedAmountInterface $minimumPriceToBid = null;
    private ?string $mpn = null;
    private ?string $pattern = null;

    /**
     * @var array<int, PaymentMethodInterface>
     */
    private array $paymentMethods = [];
    private ?ConvertedAmountInterface $price = null;
    private ?string $priceDisplayCondition = null;
    private ?ItemGroupSummaryInterface $primaryItemGroup = null;
    private ?ReviewRatingInterface $primaryProductReviewRating = null;
    private ?bool $priorityListing = null;
    private ?ProductInterface $product = null;
    private ?string $productFicheWebUrl = null;
    private ?ProductSafetyLabelsInterface $productSafetyLabels = null;

    /**
     * @var array<int, string>
     */
    private array $qualifiedPrograms = [];
    private ?int $quantityLimitPerBuyer = null;
    private ?string $repairScore = null;
    private ?bool $reservePriceMet = null;

    /**
     * @var array<int, ResponsiblePersonInterface>
     */
    private array $responsiblePersons = [];
    private ?ReturnTermsInterface $returnTerms = null;
    private ?SellerInterface $seller = null;

    /**
     * @var array<int, SellerCustomPolicyInterface>
     */
    private array $sellerCustomPolicies = [];
    private ?string $sellerItemRevision = null;

    /**
     * @var array<int, ShippingOptionInterface>
     */
    private array $shippingOptions = [];
    private ?ShipToLocationsInterface $shipToLocations = null;
    private ?string $shortDescription = null;
    private ?string $size = null;
    private ?string $sizeSystem = null;
    private ?string $sizeType = null;
    private ?string $subtitle = null;

    /**
     * @var array<int, TaxInterface>
     */
    private array $taxes = [];
    private ?string $title = null;
    private ?bool $topRatedBuyingExperience = null;
    private ?string $tyreLabelImageUrl = null;
    private ?int $uniqueBidderCount = null;
    private ?ConvertedAmountInterface $unitPrice = null;
    private ?string $unitPricingMeasure = null;

    /**
     * @var array<int, ErrorInterface>
     */
    private array $warnings = [];
    private ?int $watchCount = null;

    public function __construct(string $itemId)
    {
        $this->itemId = $itemId;
    }

    /**
     * @return array<int, ImageInterface>
     */
    public function getAdditionalImages(): array
    {
        return $this->additionalImages;
    }

    /**
     * @return array<int, AddonServiceInterface>
     */
    public function getAddonServices(): array
    {
        return $this->addonServices;
    }

    public function getAdultOnly(): ?bool
    {
        return $this->adultOnly;
    }

    public function getAgeGroup(): ?string
    {
        return $this->ageGroup;
    }

    public function getAuthenticityGuarantee(): ?AuthenticityGuaranteeProgramInterface
    {
        return $this->authenticityGuarantee;
    }

    public function getAuthenticityVerification(): ?AuthenticityVerificationProgramInterface
    {
        return $this->authenticityVerification;
    }

    /**
     * @return array<int, AvailableCouponInterface>
     */
    public function getAvailableCoupons(): array
    {
        return $this->availableCoupons;
    }

    public function getBidCount(): ?int
    {
        return $this->bidCount;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @return array<int, string>
     */
    public function getBuyingOptions(): array
    {
        return $this->buyingOptions;
    }

    public function getCategoryId(): ?string
    {
        return $this->categoryId;
    }

    public function getCategoryIdPath(): ?string
    {
        return $this->categoryIdPath;
    }

    public function getCategoryPath(): ?string
    {
        return $this->categoryPath;
    }

    public function getCharityTerms(): ?ItemCharityTermsInterface
    {
        return $this->charityTerms;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function getConditionDescription(): ?string
    {
        return $this->conditionDescription;
    }

    /**
     * @return array<int, ConditionDescriptorInterface>
     */
    public function getConditionDescriptors(): array
    {
        return $this->conditionDescriptors;
    }

    public function getConditionId(): ?string
    {
        return $this->conditionId;
    }

    public function getCurrentBidPrice(): ?ConvertedAmountInterface
    {
        return $this->currentBidPrice;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getEcoParticipationFee(): ?ConvertedAmountInterface
    {
        return $this->ecoParticipationFee;
    }

    public function getEligibleForInlineCheckout(): ?bool
    {
        return $this->eligibleForInlineCheckout;
    }

    public function getEnabledForGuestCheckout(): ?bool
    {
        return $this->enabledForGuestCheckout;
    }

    public function getEnergyEfficiencyClass(): ?string
    {
        return $this->energyEfficiencyClass;
    }

    public function getEpid(): ?string
    {
        return $this->epid;
    }

    /**
     * @return array<int, EstimatedAvailabilityInterface>
     */
    public function getEstimatedAvailabilities(): array
    {
        return $this->estimatedAvailabilities;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getGtin(): ?string
    {
        return $this->gtin;
    }

    public function getHazardousMaterialsLabels(): ?HazardousMaterialsLabelsInterface
    {
        return $this->hazardousMaterialsLabels;
    }

    public function getImage(): ?ImageInterface
    {
        return $this->image;
    }

    public function getImmediatePay(): ?bool
    {
        return $this->immediatePay;
    }

    public function getInferredEpid(): ?string
    {
        return $this->inferredEpid;
    }

    public function getItemAffiliateWebUrl(): ?string
    {
        return $this->itemAffiliateWebUrl;
    }

    public function getItemCreationDate(): ?int
    {
        return $this->itemCreationDate;
    }

    public function getItemEndDate(): ?int
    {
        return $this->itemEndDate;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getItemLocation(): ?ItemLocationInterface
    {
        return $this->itemLocation;
    }

    public function getItemWebUrl(): ?string
    {
        return $this->itemWebUrl;
    }

    public function getLegacyItemId(): ?string
    {
        return $this->legacyItemId;
    }

    public function getListingMarketplaceId(): ?string
    {
        return $this->listingMarketplaceId;
    }

    /**
     * @return array<int, TypedNameValueInterface>
     */
    public function getLocalizedAspects(): array
    {
        return $this->localizedAspects;
    }

    public function getLotSize(): ?int
    {
        return $this->lotSize;
    }

    public function getManufacturer(): ?CompanyAddressInterface
    {
        return $this->manufacturer;
    }

    public function getMarketingPrice(): ?MarketingPriceInterface
    {
        return $this->marketingPrice;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function getMinimumPriceToBid(): ?ConvertedAmountInterface
    {
        return $this->minimumPriceToBid;
    }

    public function getMpn(): ?string
    {
        return $this->mpn;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    /**
     * @return array<int, PaymentMethodInterface>
     */
    public function getPaymentMethods(): array
    {
        return $this->paymentMethods;
    }

    public function getPrice(): ?ConvertedAmountInterface
    {
        return $this->price;
    }

    public function getPriceDisplayCondition(): ?string
    {
        return $this->priceDisplayCondition;
    }

    public function getPrimaryItemGroup(): ?ItemGroupSummaryInterface
    {
        return $this->primaryItemGroup;
    }

    public function getPrimaryProductReviewRating(): ?ReviewRatingInterface
    {
        return $this->primaryProductReviewRating;
    }

    public function getPriorityListing(): ?bool
    {
        return $this->priorityListing;
    }

    public function getProduct(): ?ProductInterface
    {
        return $this->product;
    }

    public function getProductFicheWebUrl(): ?string
    {
        return $this->productFicheWebUrl;
    }

    public function getProductSafetyLabels(): ?ProductSafetyLabelsInterface
    {
        return $this->productSafetyLabels;
    }

    /**
     * @return array<int, string>
     */
    public function getQualifiedPrograms(): array
    {
        return $this->qualifiedPrograms;
    }

    public function getQuantityLimitPerBuyer(): ?int
    {
        return $this->quantityLimitPerBuyer;
    }

    public function getRepairScore(): ?string
    {
        return $this->repairScore;
    }

    public function getReservePriceMet(): ?bool
    {
        return $this->reservePriceMet;
    }

    /**
     * @return array<int, ResponsiblePersonInterface>
     */
    public function getResponsiblePersons(): array
    {
        return $this->responsiblePersons;
    }

    public function getReturnTerms(): ?ReturnTermsInterface
    {
        return $this->returnTerms;
    }

    public function getSeller(): ?SellerInterface
    {
        return $this->seller;
    }

    /**
     * @return array<int, SellerCustomPolicyInterface>
     */
    public function getSellerCustomPolicies(): array
    {
        return $this->sellerCustomPolicies;
    }

    public function getSellerItemRevision(): ?string
    {
        return $this->sellerItemRevision;
    }

    /**
     * @return array<int, ShippingOptionInterface>
     */
    public function getShippingOptions(): array
    {
        return $this->shippingOptions;
    }

    public function getShipToLocations(): ?ShipToLocationsInterface
    {
        return $this->shipToLocations;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function getSizeSystem(): ?string
    {
        return $this->sizeSystem;
    }

    public function getSizeType(): ?string
    {
        return $this->sizeType;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    /**
     * @return array<int, TaxInterface>
     */
    public function getTaxes(): array
    {
        return $this->taxes;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getTopRatedBuyingExperience(): ?bool
    {
        return $this->topRatedBuyingExperience;
    }

    public function getTyreLabelImageUrl(): ?string
    {
        return $this->tyreLabelImageUrl;
    }

    public function getUniqueBidderCount(): ?int
    {
        return $this->uniqueBidderCount;
    }

    public function getUnitPrice(): ?ConvertedAmountInterface
    {
        return $this->unitPrice;
    }

    public function getUnitPricingMeasure(): ?string
    {
        return $this->unitPricingMeasure;
    }

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    public function getWatchCount(): ?int
    {
        return $this->watchCount;
    }

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setAdditionalImages(array $value): ItemInterface
    {
        $this->additionalImages = $value;

        return $this;
    }

    /**
     * @param array<int, AddonServiceInterface> $value
     */
    public function setAddonServices(array $value): ItemInterface
    {
        $this->addonServices = $value;

        return $this;
    }

    public function setAdultOnly(?bool $value): ItemInterface
    {
        $this->adultOnly = $value;

        return $this;
    }

    public function setAgeGroup(?string $value): ItemInterface
    {
        $this->ageGroup = $value;

        return $this;
    }

    public function setAuthenticityGuarantee(?AuthenticityGuaranteeProgramInterface $value): ItemInterface
    {
        $this->authenticityGuarantee = $value;

        return $this;
    }

    public function setAuthenticityVerification(?AuthenticityVerificationProgramInterface $value): ItemInterface
    {
        $this->authenticityVerification = $value;

        return $this;
    }

    /**
     * @param array<int, AvailableCouponInterface> $value
     */
    public function setAvailableCoupons(array $value): ItemInterface
    {
        $this->availableCoupons = $value;

        return $this;
    }

    public function setBidCount(?int $value): ItemInterface
    {
        $this->bidCount = $value;

        return $this;
    }

    public function setBrand(?string $value): ItemInterface
    {
        $this->brand = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setBuyingOptions(array $value): ItemInterface
    {
        $this->buyingOptions = $value;

        return $this;
    }

    public function setCategoryId(?string $value): ItemInterface
    {
        $this->categoryId = $value;

        return $this;
    }

    public function setCategoryIdPath(?string $value): ItemInterface
    {
        $this->categoryIdPath = $value;

        return $this;
    }

    public function setCategoryPath(?string $value): ItemInterface
    {
        $this->categoryPath = $value;

        return $this;
    }

    public function setCharityTerms(?ItemCharityTermsInterface $value): ItemInterface
    {
        $this->charityTerms = $value;

        return $this;
    }

    public function setColor(?string $value): ItemInterface
    {
        $this->color = $value;

        return $this;
    }

    public function setCondition(?string $value): ItemInterface
    {
        $this->condition = $value;

        return $this;
    }

    public function setConditionDescription(?string $value): ItemInterface
    {
        $this->conditionDescription = $value;

        return $this;
    }

    /**
     * @param array<int, ConditionDescriptorInterface> $value
     */
    public function setConditionDescriptors(array $value): ItemInterface
    {
        $this->conditionDescriptors = $value;

        return $this;
    }

    public function setConditionId(?string $value): ItemInterface
    {
        $this->conditionId = $value;

        return $this;
    }

    public function setCurrentBidPrice(?ConvertedAmountInterface $value): ItemInterface
    {
        $this->currentBidPrice = $value;

        return $this;
    }

    public function setDescription(?string $value): ItemInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setEcoParticipationFee(?ConvertedAmountInterface $value): ItemInterface
    {
        $this->ecoParticipationFee = $value;

        return $this;
    }

    public function setEligibleForInlineCheckout(?bool $value): ItemInterface
    {
        $this->eligibleForInlineCheckout = $value;

        return $this;
    }

    public function setEnabledForGuestCheckout(?bool $value): ItemInterface
    {
        $this->enabledForGuestCheckout = $value;

        return $this;
    }

    public function setEnergyEfficiencyClass(?string $value): ItemInterface
    {
        $this->energyEfficiencyClass = $value;

        return $this;
    }

    public function setEpid(?string $value): ItemInterface
    {
        $this->epid = $value;

        return $this;
    }

    /**
     * @param array<int, EstimatedAvailabilityInterface> $value
     */
    public function setEstimatedAvailabilities(array $value): ItemInterface
    {
        $this->estimatedAvailabilities = $value;

        return $this;
    }

    public function setGender(?string $value): ItemInterface
    {
        $this->gender = $value;

        return $this;
    }

    public function setGtin(?string $value): ItemInterface
    {
        $this->gtin = $value;

        return $this;
    }

    public function setHazardousMaterialsLabels(?HazardousMaterialsLabelsInterface $value): ItemInterface
    {
        $this->hazardousMaterialsLabels = $value;

        return $this;
    }

    public function setImage(?ImageInterface $value): ItemInterface
    {
        $this->image = $value;

        return $this;
    }

    public function setImmediatePay(?bool $value): ItemInterface
    {
        $this->immediatePay = $value;

        return $this;
    }

    public function setInferredEpid(?string $value): ItemInterface
    {
        $this->inferredEpid = $value;

        return $this;
    }

    public function setItemAffiliateWebUrl(?string $value): ItemInterface
    {
        $this->itemAffiliateWebUrl = $value;

        return $this;
    }

    public function setItemCreationDate(?int $value): ItemInterface
    {
        $this->itemCreationDate = $value;

        return $this;
    }

    public function setItemEndDate(?int $value): ItemInterface
    {
        $this->itemEndDate = $value;

        return $this;
    }

    public function setItemId(string $value): ItemInterface
    {
        $this->itemId = $value;

        return $this;
    }

    public function setItemLocation(?ItemLocationInterface $value): ItemInterface
    {
        $this->itemLocation = $value;

        return $this;
    }

    public function setItemWebUrl(?string $value): ItemInterface
    {
        $this->itemWebUrl = $value;

        return $this;
    }

    public function setLegacyItemId(?string $value): ItemInterface
    {
        $this->legacyItemId = $value;

        return $this;
    }

    public function setListingMarketplaceId(?string $value): ItemInterface
    {
        $this->listingMarketplaceId = $value;

        return $this;
    }

    /**
     * @param array<int, TypedNameValueInterface> $value
     */
    public function setLocalizedAspects(array $value): ItemInterface
    {
        $this->localizedAspects = $value;

        return $this;
    }

    public function setLotSize(?int $value): ItemInterface
    {
        $this->lotSize = $value;

        return $this;
    }

    public function setManufacturer(?CompanyAddressInterface $value): ItemInterface
    {
        $this->manufacturer = $value;

        return $this;
    }

    public function setMarketingPrice(?MarketingPriceInterface $value): ItemInterface
    {
        $this->marketingPrice = $value;

        return $this;
    }

    public function setMaterial(?string $value): ItemInterface
    {
        $this->material = $value;

        return $this;
    }

    public function setMinimumPriceToBid(?ConvertedAmountInterface $value): ItemInterface
    {
        $this->minimumPriceToBid = $value;

        return $this;
    }

    public function setMpn(?string $value): ItemInterface
    {
        $this->mpn = $value;

        return $this;
    }

    public function setPattern(?string $value): ItemInterface
    {
        $this->pattern = $value;

        return $this;
    }

    /**
     * @param array<int, PaymentMethodInterface> $value
     */
    public function setPaymentMethods(array $value): ItemInterface
    {
        $this->paymentMethods = $value;

        return $this;
    }

    public function setPrice(?ConvertedAmountInterface $value): ItemInterface
    {
        $this->price = $value;

        return $this;
    }

    public function setPriceDisplayCondition(?string $value): ItemInterface
    {
        $this->priceDisplayCondition = $value;

        return $this;
    }

    public function setPrimaryItemGroup(?ItemGroupSummaryInterface $value): ItemInterface
    {
        $this->primaryItemGroup = $value;

        return $this;
    }

    public function setPrimaryProductReviewRating(?ReviewRatingInterface $value): ItemInterface
    {
        $this->primaryProductReviewRating = $value;

        return $this;
    }

    public function setPriorityListing(?bool $value): ItemInterface
    {
        $this->priorityListing = $value;

        return $this;
    }

    public function setProduct(?ProductInterface $value): ItemInterface
    {
        $this->product = $value;

        return $this;
    }

    public function setProductFicheWebUrl(?string $value): ItemInterface
    {
        $this->productFicheWebUrl = $value;

        return $this;
    }

    public function setProductSafetyLabels(?ProductSafetyLabelsInterface $value): ItemInterface
    {
        $this->productSafetyLabels = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setQualifiedPrograms(array $value): ItemInterface
    {
        $this->qualifiedPrograms = $value;

        return $this;
    }

    public function setQuantityLimitPerBuyer(?int $value): ItemInterface
    {
        $this->quantityLimitPerBuyer = $value;

        return $this;
    }

    public function setRepairScore(?string $value): ItemInterface
    {
        $this->repairScore = $value;

        return $this;
    }

    public function setReservePriceMet(?bool $value): ItemInterface
    {
        $this->reservePriceMet = $value;

        return $this;
    }

    /**
     * @param array<int, ResponsiblePersonInterface> $value
     */
    public function setResponsiblePersons(array $value): ItemInterface
    {
        $this->responsiblePersons = $value;

        return $this;
    }

    public function setReturnTerms(?ReturnTermsInterface $value): ItemInterface
    {
        $this->returnTerms = $value;

        return $this;
    }

    public function setSeller(?SellerInterface $value): ItemInterface
    {
        $this->seller = $value;

        return $this;
    }

    /**
     * @param array<int, SellerCustomPolicyInterface> $value
     */
    public function setSellerCustomPolicies(array $value): ItemInterface
    {
        $this->sellerCustomPolicies = $value;

        return $this;
    }

    public function setSellerItemRevision(?string $value): ItemInterface
    {
        $this->sellerItemRevision = $value;

        return $this;
    }

    /**
     * @param array<int, ShippingOptionInterface> $value
     */
    public function setShippingOptions(array $value): ItemInterface
    {
        $this->shippingOptions = $value;

        return $this;
    }

    public function setShipToLocations(?ShipToLocationsInterface $value): ItemInterface
    {
        $this->shipToLocations = $value;

        return $this;
    }

    public function setShortDescription(?string $value): ItemInterface
    {
        $this->shortDescription = $value;

        return $this;
    }

    public function setSize(?string $value): ItemInterface
    {
        $this->size = $value;

        return $this;
    }

    public function setSizeSystem(?string $value): ItemInterface
    {
        $this->sizeSystem = $value;

        return $this;
    }

    public function setSizeType(?string $value): ItemInterface
    {
        $this->sizeType = $value;

        return $this;
    }

    public function setSubtitle(?string $value): ItemInterface
    {
        $this->subtitle = $value;

        return $this;
    }

    /**
     * @param array<int, TaxInterface> $value
     */
    public function setTaxes(array $value): ItemInterface
    {
        $this->taxes = $value;

        return $this;
    }

    public function setTitle(?string $value): ItemInterface
    {
        $this->title = $value;

        return $this;
    }

    public function setTopRatedBuyingExperience(?bool $value): ItemInterface
    {
        $this->topRatedBuyingExperience = $value;

        return $this;
    }

    public function setTyreLabelImageUrl(?string $value): ItemInterface
    {
        $this->tyreLabelImageUrl = $value;

        return $this;
    }

    public function setUniqueBidderCount(?int $value): ItemInterface
    {
        $this->uniqueBidderCount = $value;

        return $this;
    }

    public function setUnitPrice(?ConvertedAmountInterface $value): ItemInterface
    {
        $this->unitPrice = $value;

        return $this;
    }

    public function setUnitPricingMeasure(?string $value): ItemInterface
    {
        $this->unitPricingMeasure = $value;

        return $this;
    }

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): ItemInterface
    {
        $this->warnings = $value;

        return $this;
    }

    public function setWatchCount(?int $value): ItemInterface
    {
        $this->watchCount = $value;

        return $this;
    }
}
