<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ItemSummaryInterface
{
    /**
     * @return array<int, ImageInterface>
     */
    public function getAdditionalImages(): array;

    public function getAdultOnly(): ?bool;

    public function getAvailableCoupons(): ?bool;

    public function getBidCount(): ?int;

    /**
     * @return array<int, string>
     */
    public function getBuyingOptions(): array;

    /**
     * @return array<int, CategoryInterface>
     */
    public function getCategories(): array;

    public function getCompatibilityMatch(): ?string;

    /**
     * @return array<int, CompatibilityPropertyInterface>
     */
    public function getCompatibilityProperties(): array;

    public function getCondition(): ?string;

    public function getConditionId(): ?string;

    public function getCurrentBidPrice(): ?ConvertedAmountInterface;

    public function getDistanceFromPickupLocation(): ?TargetLocationInterface;

    public function getEnergyEfficiencyClass(): ?string;

    public function getEpid(): ?string;

    public function getImage(): ?ImageInterface;

    public function getItemAffiliateWebUrl(): ?string;

    public function getItemCreationDate(): ?int;

    public function getItemEndDate(): ?int;

    public function getItemGroupHref(): ?string;

    public function getItemGroupType(): ?string;

    public function getItemHref(): ?string;

    public function getItemId(): string;

    public function getItemLocation(): ?ItemLocationInterface;

    public function getItemOriginDate(): ?int;

    public function getItemWebUrl(): ?string;

    /**
     * @return array<int, string>
     */
    public function getLeafCategoryIds(): array;

    public function getLegacyItemId(): ?string;

    public function getListingMarketplaceId(): ?string;

    public function getMarketingPrice(): ?MarketingPriceInterface;

    /**
     * @return array<int, PickupOptionSummaryInterface>
     */
    public function getPickupOptions(): array;

    public function getPrice(): ?ConvertedAmountInterface;

    public function getPriceDisplayCondition(): ?string;

    public function getPriorityListing(): ?bool;

    /**
     * @return array<int, string>
     */
    public function getQualifiedPrograms(): array;

    public function getSeller(): ?SellerInterface;

    /**
     * @return array<int, ShippingOptionInterface>
     */
    public function getShippingOptions(): array;

    public function getShortDescription(): ?string;

    /**
     * @return array<int, ImageInterface>
     */
    public function getThumbnailImages(): array;

    public function getTitle(): ?string;

    public function getTopRatedBuyingExperience(): ?bool;

    public function getTyreLabelImageUrl(): ?string;

    public function getUnitPrice(): ?ConvertedAmountInterface;

    public function getUnitPricingMeasure(): ?string;

    public function getWatchCount(): ?int;

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setAdditionalImages(array $value): self;

    public function setAdultOnly(?bool $value): self;

    public function setAvailableCoupons(?bool $value): self;

    public function setBidCount(?int $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setBuyingOptions(array $value): self;

    /**
     * @param array<int, CategoryInterface> $value
     */
    public function setCategories(array $value): self;

    public function setCompatibilityMatch(?string $value): self;

    /**
     * @param array<int, CompatibilityPropertyInterface> $value
     */
    public function setCompatibilityProperties(array $value): self;

    public function setCondition(?string $value): self;

    public function setConditionId(?string $value): self;

    public function setCurrentBidPrice(?ConvertedAmountInterface $value): self;

    public function setDistanceFromPickupLocation(?TargetLocationInterface $value): self;

    public function setEnergyEfficiencyClass(?string $value): self;

    public function setEpid(?string $value): self;

    public function setImage(?ImageInterface $value): self;

    public function setItemAffiliateWebUrl(?string $value): self;

    public function setItemCreationDate(?int $value): self;

    public function setItemEndDate(?int $value): self;

    public function setItemGroupHref(?string $value): self;

    public function setItemGroupType(?string $value): self;

    public function setItemHref(?string $value): self;

    public function setItemId(string $value): self;

    public function setItemLocation(?ItemLocationInterface $value): self;

    public function setItemOriginDate(?int $value): self;

    public function setItemWebUrl(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setLeafCategoryIds(array $value): self;

    public function setLegacyItemId(?string $value): self;

    public function setListingMarketplaceId(?string $value): self;

    public function setMarketingPrice(?MarketingPriceInterface $value): self;

    /**
     * @param array<int, PickupOptionSummaryInterface> $value
     */
    public function setPickupOptions(array $value): self;

    public function setPrice(?ConvertedAmountInterface $value): self;

    public function setPriceDisplayCondition(?string $value): self;

    public function setPriorityListing(?bool $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setQualifiedPrograms(array $value): self;

    public function setSeller(?SellerInterface $value): self;

    /**
     * @param array<int, ShippingOptionInterface> $value
     */
    public function setShippingOptions(array $value): self;

    public function setShortDescription(?string $value): self;

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setThumbnailImages(array $value): self;

    public function setTitle(?string $value): self;

    public function setTopRatedBuyingExperience(?bool $value): self;

    public function setTyreLabelImageUrl(?string $value): self;

    public function setUnitPrice(?ConvertedAmountInterface $value): self;

    public function setUnitPricingMeasure(?string $value): self;

    public function setWatchCount(?int $value): self;
}
