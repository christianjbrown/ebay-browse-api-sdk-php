<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ItemInterface
{
    /**
     * @return array<int, ImageInterface>
     */
    public function getAdditionalImages(): array;

    public function getAdultOnly(): ?bool;

    public function getAgeGroup(): ?string;

    public function getBidCount(): ?int;

    public function getBrand(): ?string;

    /**
     * @return array<int, string>
     */
    public function getBuyingOptions(): array;

    public function getCategoryId(): ?string;

    public function getCategoryIdPath(): ?string;

    public function getCategoryPath(): ?string;

    public function getColor(): ?string;

    public function getCondition(): ?string;

    public function getConditionDescription(): ?string;

    public function getConditionId(): ?string;

    public function getCurrentBidPrice(): ?ConvertedAmountInterface;

    public function getDescription(): ?string;

    public function getEligibleForInlineCheckout(): ?bool;

    public function getEnabledForGuestCheckout(): ?bool;

    public function getEnergyEfficiencyClass(): ?string;

    public function getEpid(): ?string;

    /**
     * @return array<int, EstimatedAvailabilityInterface>
     */
    public function getEstimatedAvailabilities(): array;

    public function getGtin(): ?string;

    public function getImage(): ?ImageInterface;

    public function getImmediatePay(): ?bool;

    public function getItemAffiliateWebUrl(): ?string;

    public function getItemCreationDate(): ?int;

    public function getItemEndDate(): ?int;

    public function getItemId(): string;

    public function getItemLocation(): ?ItemLocationInterface;

    public function getItemWebUrl(): ?string;

    public function getLegacyItemId(): ?string;

    public function getListingMarketplaceId(): ?string;

    /**
     * @return array<int, TypedNameValueInterface>
     */
    public function getLocalizedAspects(): array;

    public function getLotSize(): ?int;

    public function getMarketingPrice(): ?MarketingPriceInterface;

    public function getMaterial(): ?string;

    public function getMpn(): ?string;

    /**
     * @return array<int, PaymentMethodInterface>
     */
    public function getPaymentMethods(): array;

    public function getPrice(): ?ConvertedAmountInterface;

    public function getPriorityListing(): ?bool;

    public function getProduct(): ?ProductInterface;

    public function getReturnTerms(): ?ReturnTermsInterface;

    public function getSeller(): ?SellerInterface;

    public function getSellerItemRevision(): ?string;

    /**
     * @return array<int, ShippingOptionInterface>
     */
    public function getShippingOptions(): array;

    public function getShipToLocations(): ?ShipToLocationsInterface;

    public function getShortDescription(): ?string;

    public function getSubtitle(): ?string;

    public function getTitle(): ?string;

    public function getTopRatedBuyingExperience(): ?bool;

    public function getUniqueBidderCount(): ?int;

    public function getUnitPrice(): ?ConvertedAmountInterface;

    public function getUnitPricingMeasure(): ?string;

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array;

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setAdditionalImages(array $value): self;

    public function setAdultOnly(?bool $value): self;

    public function setAgeGroup(?string $value): self;

    public function setBidCount(?int $value): self;

    public function setBrand(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setBuyingOptions(array $value): self;

    public function setCategoryId(?string $value): self;

    public function setCategoryIdPath(?string $value): self;

    public function setCategoryPath(?string $value): self;

    public function setColor(?string $value): self;

    public function setCondition(?string $value): self;

    public function setConditionDescription(?string $value): self;

    public function setConditionId(?string $value): self;

    public function setCurrentBidPrice(?ConvertedAmountInterface $value): self;

    public function setDescription(?string $value): self;

    public function setEligibleForInlineCheckout(?bool $value): self;

    public function setEnabledForGuestCheckout(?bool $value): self;

    public function setEnergyEfficiencyClass(?string $value): self;

    public function setEpid(?string $value): self;

    /**
     * @param array<int, EstimatedAvailabilityInterface> $value
     */
    public function setEstimatedAvailabilities(array $value): self;

    public function setGtin(?string $value): self;

    public function setImage(?ImageInterface $value): self;

    public function setImmediatePay(?bool $value): self;

    public function setItemAffiliateWebUrl(?string $value): self;

    public function setItemCreationDate(?int $value): self;

    public function setItemEndDate(?int $value): self;

    public function setItemId(string $value): self;

    public function setItemLocation(?ItemLocationInterface $value): self;

    public function setItemWebUrl(?string $value): self;

    public function setLegacyItemId(?string $value): self;

    public function setListingMarketplaceId(?string $value): self;

    /**
     * @param array<int, TypedNameValueInterface> $value
     */
    public function setLocalizedAspects(array $value): self;

    public function setLotSize(?int $value): self;

    public function setMarketingPrice(?MarketingPriceInterface $value): self;

    public function setMaterial(?string $value): self;

    public function setMpn(?string $value): self;

    /**
     * @param array<int, PaymentMethodInterface> $value
     */
    public function setPaymentMethods(array $value): self;

    public function setPrice(?ConvertedAmountInterface $value): self;

    public function setPriorityListing(?bool $value): self;

    public function setProduct(?ProductInterface $value): self;

    public function setReturnTerms(?ReturnTermsInterface $value): self;

    public function setSeller(?SellerInterface $value): self;

    public function setSellerItemRevision(?string $value): self;

    /**
     * @param array<int, ShippingOptionInterface> $value
     */
    public function setShippingOptions(array $value): self;

    public function setShipToLocations(?ShipToLocationsInterface $value): self;

    public function setShortDescription(?string $value): self;

    public function setSubtitle(?string $value): self;

    public function setTitle(?string $value): self;

    public function setTopRatedBuyingExperience(?bool $value): self;

    public function setUniqueBidderCount(?int $value): self;

    public function setUnitPrice(?ConvertedAmountInterface $value): self;

    public function setUnitPricingMeasure(?string $value): self;

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): self;
}
