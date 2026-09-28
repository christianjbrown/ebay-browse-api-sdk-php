<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ItemSummary implements ItemSummaryInterface
{
    /**
     * @var array<int, ImageInterface>
     */
    private array $additionalImages = [];
    private ?bool $adultOnly = null;
    private ?bool $availableCoupons = null;
    private ?int $bidCount = null;

    /**
     * @var array<int, string>
     */
    private array $buyingOptions = [];

    /**
     * @var array<int, CategoryInterface>
     */
    private array $categories = [];
    private ?string $compatibilityMatch = null;

    /**
     * @var array<int, CompatibilityPropertyInterface>
     */
    private array $compatibilityProperties = [];
    private ?string $condition = null;
    private ?string $conditionId = null;
    private ?ConvertedAmountInterface $currentBidPrice = null;
    private ?TargetLocationInterface $distanceFromPickupLocation = null;
    private ?string $energyEfficiencyClass = null;
    private ?string $epid = null;
    private ?ImageInterface $image = null;
    private ?string $itemAffiliateWebUrl = null;
    private ?int $itemCreationDate = null;
    private ?int $itemEndDate = null;
    private ?string $itemGroupHref = null;
    private ?string $itemGroupType = null;
    private ?string $itemHref = null;
    private string $itemId;
    private ?ItemLocationInterface $itemLocation = null;
    private ?int $itemOriginDate = null;
    private ?string $itemWebUrl = null;

    /**
     * @var array<int, string>
     */
    private array $leafCategoryIds = [];
    private ?string $legacyItemId = null;
    private ?string $listingMarketplaceId = null;
    private ?MarketingPriceInterface $marketingPrice = null;

    /**
     * @var array<int, PickupOptionSummaryInterface>
     */
    private array $pickupOptions = [];
    private ?ConvertedAmountInterface $price = null;
    private ?string $priceDisplayCondition = null;
    private ?bool $priorityListing = null;

    /**
     * @var array<int, string>
     */
    private array $qualifiedPrograms = [];
    private ?SellerInterface $seller = null;

    /**
     * @var array<int, ShippingOptionInterface>
     */
    private array $shippingOptions = [];
    private ?string $shortDescription = null;

    /**
     * @var array<int, ImageInterface>
     */
    private array $thumbnailImages = [];
    private ?string $title = null;
    private ?bool $topRatedBuyingExperience = null;
    private ?string $tyreLabelImageUrl = null;
    private ?ConvertedAmountInterface $unitPrice = null;
    private ?string $unitPricingMeasure = null;
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

    public function getAdultOnly(): ?bool
    {
        return $this->adultOnly;
    }

    public function getAvailableCoupons(): ?bool
    {
        return $this->availableCoupons;
    }

    public function getBidCount(): ?int
    {
        return $this->bidCount;
    }

    /**
     * @return array<int, string>
     */
    public function getBuyingOptions(): array
    {
        return $this->buyingOptions;
    }

    /**
     * @return array<int, CategoryInterface>
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getCompatibilityMatch(): ?string
    {
        return $this->compatibilityMatch;
    }

    /**
     * @return array<int, CompatibilityPropertyInterface>
     */
    public function getCompatibilityProperties(): array
    {
        return $this->compatibilityProperties;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function getConditionId(): ?string
    {
        return $this->conditionId;
    }

    public function getCurrentBidPrice(): ?ConvertedAmountInterface
    {
        return $this->currentBidPrice;
    }

    public function getDistanceFromPickupLocation(): ?TargetLocationInterface
    {
        return $this->distanceFromPickupLocation;
    }

    public function getEnergyEfficiencyClass(): ?string
    {
        return $this->energyEfficiencyClass;
    }

    public function getEpid(): ?string
    {
        return $this->epid;
    }

    public function getImage(): ?ImageInterface
    {
        return $this->image;
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

    public function getItemGroupHref(): ?string
    {
        return $this->itemGroupHref;
    }

    public function getItemGroupType(): ?string
    {
        return $this->itemGroupType;
    }

    public function getItemHref(): ?string
    {
        return $this->itemHref;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    public function getItemLocation(): ?ItemLocationInterface
    {
        return $this->itemLocation;
    }

    public function getItemOriginDate(): ?int
    {
        return $this->itemOriginDate;
    }

    public function getItemWebUrl(): ?string
    {
        return $this->itemWebUrl;
    }

    /**
     * @return array<int, string>
     */
    public function getLeafCategoryIds(): array
    {
        return $this->leafCategoryIds;
    }

    public function getLegacyItemId(): ?string
    {
        return $this->legacyItemId;
    }

    public function getListingMarketplaceId(): ?string
    {
        return $this->listingMarketplaceId;
    }

    public function getMarketingPrice(): ?MarketingPriceInterface
    {
        return $this->marketingPrice;
    }

    /**
     * @return array<int, PickupOptionSummaryInterface>
     */
    public function getPickupOptions(): array
    {
        return $this->pickupOptions;
    }

    public function getPrice(): ?ConvertedAmountInterface
    {
        return $this->price;
    }

    public function getPriceDisplayCondition(): ?string
    {
        return $this->priceDisplayCondition;
    }

    public function getPriorityListing(): ?bool
    {
        return $this->priorityListing;
    }

    /**
     * @return array<int, string>
     */
    public function getQualifiedPrograms(): array
    {
        return $this->qualifiedPrograms;
    }

    public function getSeller(): ?SellerInterface
    {
        return $this->seller;
    }

    /**
     * @return array<int, ShippingOptionInterface>
     */
    public function getShippingOptions(): array
    {
        return $this->shippingOptions;
    }

    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @return array<int, ImageInterface>
     */
    public function getThumbnailImages(): array
    {
        return $this->thumbnailImages;
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

    public function getUnitPrice(): ?ConvertedAmountInterface
    {
        return $this->unitPrice;
    }

    public function getUnitPricingMeasure(): ?string
    {
        return $this->unitPricingMeasure;
    }

    public function getWatchCount(): ?int
    {
        return $this->watchCount;
    }

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setAdditionalImages(array $value): ItemSummaryInterface
    {
        $this->additionalImages = $value;

        return $this;
    }

    public function setAdultOnly(?bool $value): ItemSummaryInterface
    {
        $this->adultOnly = $value;

        return $this;
    }

    public function setAvailableCoupons(?bool $value): ItemSummaryInterface
    {
        $this->availableCoupons = $value;

        return $this;
    }

    public function setBidCount(?int $value): ItemSummaryInterface
    {
        $this->bidCount = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setBuyingOptions(array $value): ItemSummaryInterface
    {
        $this->buyingOptions = $value;

        return $this;
    }

    /**
     * @param array<int, CategoryInterface> $value
     */
    public function setCategories(array $value): ItemSummaryInterface
    {
        $this->categories = $value;

        return $this;
    }

    public function setCompatibilityMatch(?string $value): ItemSummaryInterface
    {
        $this->compatibilityMatch = $value;

        return $this;
    }

    /**
     * @param array<int, CompatibilityPropertyInterface> $value
     */
    public function setCompatibilityProperties(array $value): ItemSummaryInterface
    {
        $this->compatibilityProperties = $value;

        return $this;
    }

    public function setCondition(?string $value): ItemSummaryInterface
    {
        $this->condition = $value;

        return $this;
    }

    public function setConditionId(?string $value): ItemSummaryInterface
    {
        $this->conditionId = $value;

        return $this;
    }

    public function setCurrentBidPrice(?ConvertedAmountInterface $value): ItemSummaryInterface
    {
        $this->currentBidPrice = $value;

        return $this;
    }

    public function setDistanceFromPickupLocation(?TargetLocationInterface $value): ItemSummaryInterface
    {
        $this->distanceFromPickupLocation = $value;

        return $this;
    }

    public function setEnergyEfficiencyClass(?string $value): ItemSummaryInterface
    {
        $this->energyEfficiencyClass = $value;

        return $this;
    }

    public function setEpid(?string $value): ItemSummaryInterface
    {
        $this->epid = $value;

        return $this;
    }

    public function setImage(?ImageInterface $value): ItemSummaryInterface
    {
        $this->image = $value;

        return $this;
    }

    public function setItemAffiliateWebUrl(?string $value): ItemSummaryInterface
    {
        $this->itemAffiliateWebUrl = $value;

        return $this;
    }

    public function setItemCreationDate(?int $value): ItemSummaryInterface
    {
        $this->itemCreationDate = $value;

        return $this;
    }

    public function setItemEndDate(?int $value): ItemSummaryInterface
    {
        $this->itemEndDate = $value;

        return $this;
    }

    public function setItemGroupHref(?string $value): ItemSummaryInterface
    {
        $this->itemGroupHref = $value;

        return $this;
    }

    public function setItemGroupType(?string $value): ItemSummaryInterface
    {
        $this->itemGroupType = $value;

        return $this;
    }

    public function setItemHref(?string $value): ItemSummaryInterface
    {
        $this->itemHref = $value;

        return $this;
    }

    public function setItemId(string $value): ItemSummaryInterface
    {
        $this->itemId = $value;

        return $this;
    }

    public function setItemLocation(?ItemLocationInterface $value): ItemSummaryInterface
    {
        $this->itemLocation = $value;

        return $this;
    }

    public function setItemOriginDate(?int $value): ItemSummaryInterface
    {
        $this->itemOriginDate = $value;

        return $this;
    }

    public function setItemWebUrl(?string $value): ItemSummaryInterface
    {
        $this->itemWebUrl = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setLeafCategoryIds(array $value): ItemSummaryInterface
    {
        $this->leafCategoryIds = $value;

        return $this;
    }

    public function setLegacyItemId(?string $value): ItemSummaryInterface
    {
        $this->legacyItemId = $value;

        return $this;
    }

    public function setListingMarketplaceId(?string $value): ItemSummaryInterface
    {
        $this->listingMarketplaceId = $value;

        return $this;
    }

    public function setMarketingPrice(?MarketingPriceInterface $value): ItemSummaryInterface
    {
        $this->marketingPrice = $value;

        return $this;
    }

    /**
     * @param array<int, PickupOptionSummaryInterface> $value
     */
    public function setPickupOptions(array $value): ItemSummaryInterface
    {
        $this->pickupOptions = $value;

        return $this;
    }

    public function setPrice(?ConvertedAmountInterface $value): ItemSummaryInterface
    {
        $this->price = $value;

        return $this;
    }

    public function setPriceDisplayCondition(?string $value): ItemSummaryInterface
    {
        $this->priceDisplayCondition = $value;

        return $this;
    }

    public function setPriorityListing(?bool $value): ItemSummaryInterface
    {
        $this->priorityListing = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setQualifiedPrograms(array $value): ItemSummaryInterface
    {
        $this->qualifiedPrograms = $value;

        return $this;
    }

    public function setSeller(?SellerInterface $value): ItemSummaryInterface
    {
        $this->seller = $value;

        return $this;
    }

    /**
     * @param array<int, ShippingOptionInterface> $value
     */
    public function setShippingOptions(array $value): ItemSummaryInterface
    {
        $this->shippingOptions = $value;

        return $this;
    }

    public function setShortDescription(?string $value): ItemSummaryInterface
    {
        $this->shortDescription = $value;

        return $this;
    }

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setThumbnailImages(array $value): ItemSummaryInterface
    {
        $this->thumbnailImages = $value;

        return $this;
    }

    public function setTitle(?string $value): ItemSummaryInterface
    {
        $this->title = $value;

        return $this;
    }

    public function setTopRatedBuyingExperience(?bool $value): ItemSummaryInterface
    {
        $this->topRatedBuyingExperience = $value;

        return $this;
    }

    public function setTyreLabelImageUrl(?string $value): ItemSummaryInterface
    {
        $this->tyreLabelImageUrl = $value;

        return $this;
    }

    public function setUnitPrice(?ConvertedAmountInterface $value): ItemSummaryInterface
    {
        $this->unitPrice = $value;

        return $this;
    }

    public function setUnitPricingMeasure(?string $value): ItemSummaryInterface
    {
        $this->unitPricingMeasure = $value;

        return $this;
    }

    public function setWatchCount(?int $value): ItemSummaryInterface
    {
        $this->watchCount = $value;

        return $this;
    }
}
