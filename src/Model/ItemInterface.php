<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ItemInterface
{
    /**
     * @return array<int, ImageInterface>
     */
    public function getAdditionalImages(): array;

    /**
     * @return array<int, AddonServiceInterface>
     */
    public function getAddonServices(): array;

    public function getAdultOnly(): ?bool;

    public function getAgeGroup(): ?string;

    public function getAuthenticityGuarantee(): ?AuthenticityGuaranteeProgramInterface;

    public function getAuthenticityVerification(): ?AuthenticityVerificationProgramInterface;

    /**
     * @return array<int, AvailableCouponInterface>
     */
    public function getAvailableCoupons(): array;

    public function getBidCount(): ?int;

    public function getBrand(): ?string;

    /**
     * @return array<int, string>
     */
    public function getBuyingOptions(): array;

    public function getCategoryId(): ?string;

    public function getCategoryIdPath(): ?string;

    public function getCategoryPath(): ?string;

    public function getCharityTerms(): ?ItemCharityTermsInterface;

    public function getColor(): ?string;

    public function getCondition(): ?string;

    public function getConditionDescription(): ?string;

    /**
     * @return array<int, ConditionDescriptorInterface>
     */
    public function getConditionDescriptors(): array;

    public function getConditionId(): ?string;

    public function getCurrentBidPrice(): ?ConvertedAmountInterface;

    public function getDescription(): ?string;

    public function getEcoParticipationFee(): ?ConvertedAmountInterface;

    public function getEligibleForInlineCheckout(): ?bool;

    public function getEnabledForGuestCheckout(): ?bool;

    public function getEnergyEfficiencyClass(): ?string;

    public function getEpid(): ?string;

    /**
     * @return array<int, EstimatedAvailabilityInterface>
     */
    public function getEstimatedAvailabilities(): array;

    public function getGender(): ?string;

    public function getGtin(): ?string;

    public function getHazardousMaterialsLabels(): ?HazardousMaterialsLabelsInterface;

    public function getImage(): ?ImageInterface;

    public function getImmediatePay(): ?bool;

    public function getInferredEpid(): ?string;

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

    public function getManufacturer(): ?CompanyAddressInterface;

    public function getMarketingPrice(): ?MarketingPriceInterface;

    public function getMaterial(): ?string;

    public function getMinimumPriceToBid(): ?ConvertedAmountInterface;

    public function getMpn(): ?string;

    public function getPattern(): ?string;

    /**
     * @return array<int, PaymentMethodInterface>
     */
    public function getPaymentMethods(): array;

    public function getPrice(): ?ConvertedAmountInterface;

    public function getPriceDisplayCondition(): ?string;

    public function getPrimaryItemGroup(): ?ItemGroupSummaryInterface;

    public function getPrimaryProductReviewRating(): ?ReviewRatingInterface;

    public function getPriorityListing(): ?bool;

    public function getProduct(): ?ProductInterface;

    public function getProductFicheWebUrl(): ?string;

    public function getProductSafetyLabels(): ?ProductSafetyLabelsInterface;

    /**
     * @return array<int, string>
     */
    public function getQualifiedPrograms(): array;

    public function getQuantityLimitPerBuyer(): ?int;

    public function getRepairScore(): ?string;

    public function getReservePriceMet(): ?bool;

    /**
     * @return array<int, ResponsiblePersonInterface>
     */
    public function getResponsiblePersons(): array;

    public function getReturnTerms(): ?ReturnTermsInterface;

    public function getSeller(): ?SellerInterface;

    /**
     * @return array<int, SellerCustomPolicyInterface>
     */
    public function getSellerCustomPolicies(): array;

    public function getSellerItemRevision(): ?string;

    /**
     * @return array<int, ShippingOptionInterface>
     */
    public function getShippingOptions(): array;

    public function getShipToLocations(): ?ShipToLocationsInterface;

    public function getShortDescription(): ?string;

    public function getSize(): ?string;

    public function getSizeSystem(): ?string;

    public function getSizeType(): ?string;

    public function getSubtitle(): ?string;

    /**
     * @return array<int, TaxInterface>
     */
    public function getTaxes(): array;

    public function getTitle(): ?string;

    public function getTopRatedBuyingExperience(): ?bool;

    public function getTyreLabelImageUrl(): ?string;

    public function getUniqueBidderCount(): ?int;

    public function getUnitPrice(): ?ConvertedAmountInterface;

    public function getUnitPricingMeasure(): ?string;

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array;

    public function getWatchCount(): ?int;

    /**
     * @param array<int, ImageInterface> $value
     */
    public function setAdditionalImages(array $value): self;

    /**
     * @param array<int, AddonServiceInterface> $value
     */
    public function setAddonServices(array $value): self;

    public function setAdultOnly(?bool $value): self;

    public function setAgeGroup(?string $value): self;

    public function setAuthenticityGuarantee(?AuthenticityGuaranteeProgramInterface $value): self;

    public function setAuthenticityVerification(?AuthenticityVerificationProgramInterface $value): self;

    /**
     * @param array<int, AvailableCouponInterface> $value
     */
    public function setAvailableCoupons(array $value): self;

    public function setBidCount(?int $value): self;

    public function setBrand(?string $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setBuyingOptions(array $value): self;

    public function setCategoryId(?string $value): self;

    public function setCategoryIdPath(?string $value): self;

    public function setCategoryPath(?string $value): self;

    public function setCharityTerms(?ItemCharityTermsInterface $value): self;

    public function setColor(?string $value): self;

    public function setCondition(?string $value): self;

    public function setConditionDescription(?string $value): self;

    /**
     * @param array<int, ConditionDescriptorInterface> $value
     */
    public function setConditionDescriptors(array $value): self;

    public function setConditionId(?string $value): self;

    public function setCurrentBidPrice(?ConvertedAmountInterface $value): self;

    public function setDescription(?string $value): self;

    public function setEcoParticipationFee(?ConvertedAmountInterface $value): self;

    public function setEligibleForInlineCheckout(?bool $value): self;

    public function setEnabledForGuestCheckout(?bool $value): self;

    public function setEnergyEfficiencyClass(?string $value): self;

    public function setEpid(?string $value): self;

    /**
     * @param array<int, EstimatedAvailabilityInterface> $value
     */
    public function setEstimatedAvailabilities(array $value): self;

    public function setGender(?string $value): self;

    public function setGtin(?string $value): self;

    public function setHazardousMaterialsLabels(?HazardousMaterialsLabelsInterface $value): self;

    public function setImage(?ImageInterface $value): self;

    public function setImmediatePay(?bool $value): self;

    public function setInferredEpid(?string $value): self;

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

    public function setManufacturer(?CompanyAddressInterface $value): self;

    public function setMarketingPrice(?MarketingPriceInterface $value): self;

    public function setMaterial(?string $value): self;

    public function setMinimumPriceToBid(?ConvertedAmountInterface $value): self;

    public function setMpn(?string $value): self;

    public function setPattern(?string $value): self;

    /**
     * @param array<int, PaymentMethodInterface> $value
     */
    public function setPaymentMethods(array $value): self;

    public function setPrice(?ConvertedAmountInterface $value): self;

    public function setPriceDisplayCondition(?string $value): self;

    public function setPrimaryItemGroup(?ItemGroupSummaryInterface $value): self;

    public function setPrimaryProductReviewRating(?ReviewRatingInterface $value): self;

    public function setPriorityListing(?bool $value): self;

    public function setProduct(?ProductInterface $value): self;

    public function setProductFicheWebUrl(?string $value): self;

    public function setProductSafetyLabels(?ProductSafetyLabelsInterface $value): self;

    /**
     * @param array<int, string> $value
     */
    public function setQualifiedPrograms(array $value): self;

    public function setQuantityLimitPerBuyer(?int $value): self;

    public function setRepairScore(?string $value): self;

    public function setReservePriceMet(?bool $value): self;

    /**
     * @param array<int, ResponsiblePersonInterface> $value
     */
    public function setResponsiblePersons(array $value): self;

    public function setReturnTerms(?ReturnTermsInterface $value): self;

    public function setSeller(?SellerInterface $value): self;

    /**
     * @param array<int, SellerCustomPolicyInterface> $value
     */
    public function setSellerCustomPolicies(array $value): self;

    public function setSellerItemRevision(?string $value): self;

    /**
     * @param array<int, ShippingOptionInterface> $value
     */
    public function setShippingOptions(array $value): self;

    public function setShipToLocations(?ShipToLocationsInterface $value): self;

    public function setShortDescription(?string $value): self;

    public function setSize(?string $value): self;

    public function setSizeSystem(?string $value): self;

    public function setSizeType(?string $value): self;

    public function setSubtitle(?string $value): self;

    /**
     * @param array<int, TaxInterface> $value
     */
    public function setTaxes(array $value): self;

    public function setTitle(?string $value): self;

    public function setTopRatedBuyingExperience(?bool $value): self;

    public function setTyreLabelImageUrl(?string $value): self;

    public function setUniqueBidderCount(?int $value): self;

    public function setUnitPrice(?ConvertedAmountInterface $value): self;

    public function setUnitPricingMeasure(?string $value): self;

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): self;

    public function setWatchCount(?int $value): self;
}
