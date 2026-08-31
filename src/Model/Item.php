<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class Item implements ItemInterface
{
    /**
     * @var array<int, ImageInterface>
     */
    private array $additionalImages = [];
    private ?bool $adultOnly = null;
    private ?string $ageGroup = null;
    private ?int $bidCount = null;
    private ?string $brand = null;

    /**
     * @var array<int, string>
     */
    private array $buyingOptions = [];
    private ?string $categoryId = null;
    private ?string $categoryIdPath = null;
    private ?string $categoryPath = null;
    private ?string $color = null;
    private ?string $condition = null;
    private ?string $conditionDescription = null;
    private ?string $conditionId = null;
    private ?ConvertedAmountInterface $currentBidPrice = null;
    private ?string $description = null;
    private ?bool $eligibleForInlineCheckout = null;
    private ?bool $enabledForGuestCheckout = null;
    private ?string $energyEfficiencyClass = null;
    private ?string $epid = null;

    /**
     * @var array<int, EstimatedAvailabilityInterface>
     */
    private array $estimatedAvailabilities = [];
    private ?string $gtin = null;
    private ?ImageInterface $image = null;
    private ?bool $immediatePay = null;
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
    private ?MarketingPriceInterface $marketingPrice = null;
    private ?string $material = null;
    private ?string $mpn = null;

    /**
     * @var array<int, PaymentMethodInterface>
     */
    private array $paymentMethods = [];
    private ?ConvertedAmountInterface $price = null;
    private ?bool $priorityListing = null;
    private ?ProductInterface $product = null;
    private ?ReturnTermsInterface $returnTerms = null;
    private ?SellerInterface $seller = null;
    private ?string $sellerItemRevision = null;

    /**
     * @var array<int, ShippingOptionInterface>
     */
    private array $shippingOptions = [];
    private ?ShipToLocationsInterface $shipToLocations = null;
    private ?string $shortDescription = null;
    private ?string $subtitle = null;
    private ?string $title = null;
    private ?bool $topRatedBuyingExperience = null;
    private ?int $uniqueBidderCount = null;
    private ?ConvertedAmountInterface $unitPrice = null;
    private ?string $unitPricingMeasure = null;

    /**
     * @var array<int, ErrorInterface>
     */
    private array $warnings = [];

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

    public function getAdultOnly(): ?bool
    {
        return $this->adultOnly;
    }

    public function getAgeGroup(): ?string
    {
        return $this->ageGroup;
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

    public function getGtin(): ?string
    {
        return $this->gtin;
    }

    public function getImage(): ?ImageInterface
    {
        return $this->image;
    }

    public function getImmediatePay(): ?bool
    {
        return $this->immediatePay;
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

    public function getMarketingPrice(): ?MarketingPriceInterface
    {
        return $this->marketingPrice;
    }

    public function getMaterial(): ?string
    {
        return $this->material;
    }

    public function getMpn(): ?string
    {
        return $this->mpn;
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

    public function getPriorityListing(): ?bool
    {
        return $this->priorityListing;
    }

    public function getProduct(): ?ProductInterface
    {
        return $this->product;
    }

    public function getReturnTerms(): ?ReturnTermsInterface
    {
        return $this->returnTerms;
    }

    public function getSeller(): ?SellerInterface
    {
        return $this->seller;
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

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getTopRatedBuyingExperience(): ?bool
    {
        return $this->topRatedBuyingExperience;
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

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setAdditionalImages(array $value): ItemInterface
    {
        $this->additionalImages = $value;

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

    public function setGtin(?string $value): ItemInterface
    {
        $this->gtin = $value;

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

    public function setMpn(?string $value): ItemInterface
    {
        $this->mpn = $value;

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

    public function setSubtitle(?string $value): ItemInterface
    {
        $this->subtitle = $value;

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
}
