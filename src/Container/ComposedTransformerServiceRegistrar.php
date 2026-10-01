<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Transformer\AdditionalProductIdentitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\AdditionalProductIdentityTransformer;
use ChristianBrown\EBay\Browse\Transformer\AddonServicesTransformer;
use ChristianBrown\EBay\Browse\Transformer\AddonServiceTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectGroupsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectGroupTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AvailableCouponTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoriesTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityPropertiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorValuesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDescriptorValueTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilityTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardousMaterialsLabelsTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardPictogramsTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardStatementsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemCharityTermsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemComplianceTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemConditionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemDescriptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemFulfilmentTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemListingTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemMediaTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemPricingTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemProductTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemsResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemSummariesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformer;
use ChristianBrown\EBay\Browse\Transformer\MarketingPriceTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandsTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodsTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodTransformer;
use ChristianBrown\EBay\Browse\Transformer\PickupOptionSummariesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductIdentitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelPictogramsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelStatementsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductTransformer;
use ChristianBrown\EBay\Browse\Transformer\RatingHistogramsTransformer;
use ChristianBrown\EBay\Browse\Transformer\RefinementTransformer;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ResponsiblePersonTransformer;
use ChristianBrown\EBay\Browse\Transformer\ReturnTermsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ReviewRatingTransformer;
use ChristianBrown\EBay\Browse\Transformer\SearchPagedCollectionTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPoliciesTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerLegalInfoTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\TaxesTransformer;
use ChristianBrown\EBay\Browse\Transformer\TaxJurisdictionTransformer;
use ChristianBrown\EBay\Browse\Transformer\TaxTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformer;
use ChristianBrown\EBay\Browse\Transformer\VatDetailsTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ComposedTransformerServiceRegistrar implements ComposedTransformerServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(BrowseInterface::SERVICE_PRODUCT_IDENTITIES_TRANSFORMER, ProductIdentitiesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_PRODUCT_IDENTITY_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ADDITIONAL_PRODUCT_IDENTITY_TRANSFORMER, AdditionalProductIdentityTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_PRODUCT_IDENTITIES_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ADDITIONAL_PRODUCT_IDENTITIES_TRANSFORMER, AdditionalProductIdentitiesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ADDITIONAL_PRODUCT_IDENTITY_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ADDON_SERVICE_TRANSFORMER, AddonServiceTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ADDON_SERVICES_TRANSFORMER, AddonServicesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ADDON_SERVICE_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ASPECT_VALUE_DISTRIBUTIONS_TRANSFORMER, AspectValueDistributionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ASPECT_VALUE_DISTRIBUTION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ASPECT_DISTRIBUTION_TRANSFORMER, AspectDistributionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ASPECT_VALUE_DISTRIBUTIONS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ASPECT_DISTRIBUTIONS_TRANSFORMER, AspectDistributionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ASPECT_DISTRIBUTION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ASPECT_TRANSFORMER, AspectTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ASPECTS_TRANSFORMER, AspectsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ASPECT_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ASPECT_GROUP_TRANSFORMER, AspectGroupTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ASPECTS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ASPECT_GROUPS_TRANSFORMER, AspectGroupsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ASPECT_GROUP_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_AVAILABLE_COUPON_TRANSFORMER, AvailableCouponTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_COUPON_CONSTRAINT_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_AVAILABLE_COUPONS_TRANSFORMER, AvailableCouponsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_AVAILABLE_COUPON_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_BUYING_OPTION_DISTRIBUTIONS_TRANSFORMER, BuyingOptionDistributionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_BUYING_OPTION_DISTRIBUTION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_CATEGORIES_TRANSFORMER, CategoriesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CATEGORY_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_CATEGORY_DISTRIBUTIONS_TRANSFORMER, CategoryDistributionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CATEGORY_DISTRIBUTION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_COMMON_DESCRIPTION_TRANSFORMER, CommonDescriptionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_COMMON_DESCRIPTIONS_TRANSFORMER, CommonDescriptionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_COMMON_DESCRIPTION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_COMPATIBILITY_PROPERTIES_TRANSFORMER, CompatibilityPropertiesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_COMPATIBILITY_PROPERTY_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ERROR_PARAMETERS_TRANSFORMER, ErrorParametersTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ERROR_PARAMETER_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ERROR_TRANSFORMER, ErrorTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ERROR_PARAMETERS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ERRORS_TRANSFORMER, ErrorsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ERROR_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_COMPATIBILITY_RESPONSE_TRANSFORMER, CompatibilityResponseTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ERRORS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_CONDITION_DESCRIPTOR_VALUE_TRANSFORMER, ConditionDescriptorValueTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_CONDITION_DESCRIPTOR_VALUES_TRANSFORMER, ConditionDescriptorValuesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CONDITION_DESCRIPTOR_VALUE_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_CONDITION_DESCRIPTOR_TRANSFORMER, ConditionDescriptorTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CONDITION_DESCRIPTOR_VALUES_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_CONDITION_DESCRIPTORS_TRANSFORMER, ConditionDescriptorsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CONDITION_DESCRIPTOR_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_CONDITION_DISTRIBUTIONS_TRANSFORMER, ConditionDistributionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CONDITION_DISTRIBUTION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ESTIMATED_AVAILABILITY_TRANSFORMER, EstimatedAvailabilityTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ESTIMATED_AVAILABILITIES_TRANSFORMER, EstimatedAvailabilitiesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ESTIMATED_AVAILABILITY_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_HAZARD_PICTOGRAMS_TRANSFORMER, HazardPictogramsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_HAZARD_PICTOGRAM_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_HAZARD_STATEMENTS_TRANSFORMER, HazardStatementsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_HAZARD_STATEMENT_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_HAZARDOUS_MATERIALS_LABELS_TRANSFORMER, HazardousMaterialsLabelsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_HAZARD_PICTOGRAMS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_HAZARD_STATEMENTS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_IMAGES_TRANSFORMER, ImagesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_CHARITY_TERMS_TRANSFORMER, ItemCharityTermsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_GROUP_SUMMARY_TRANSFORMER, ItemGroupSummaryTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGES_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_MARKETING_PRICE_TRANSFORMER, MarketingPriceTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_PAYMENT_METHOD_BRAND_TRANSFORMER, PaymentMethodBrandTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_PAYMENT_METHOD_BRANDS_TRANSFORMER, PaymentMethodBrandsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_PAYMENT_METHOD_BRAND_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_PAYMENT_METHOD_TRANSFORMER, PaymentMethodTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_PAYMENT_METHOD_BRANDS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_PAYMENT_METHODS_TRANSFORMER, PaymentMethodsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_PAYMENT_METHOD_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_PRODUCT_SAFETY_LABEL_PICTOGRAMS_TRANSFORMER, ProductSafetyLabelPictogramsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_PRODUCT_SAFETY_LABEL_PICTOGRAM_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_PRODUCT_SAFETY_LABEL_STATEMENTS_TRANSFORMER, ProductSafetyLabelStatementsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_PRODUCT_SAFETY_LABEL_STATEMENT_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_PRODUCT_SAFETY_LABELS_TRANSFORMER, ProductSafetyLabelsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_PRODUCT_SAFETY_LABEL_PICTOGRAMS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_PRODUCT_SAFETY_LABEL_STATEMENTS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_PRODUCT_TRANSFORMER, ProductTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ADDITIONAL_PRODUCT_IDENTITIES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ASPECT_GROUPS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_RESPONSIBLE_PERSON_TRANSFORMER, ResponsiblePersonTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_RESPONSIBLE_PERSONS_TRANSFORMER, ResponsiblePersonsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_RESPONSIBLE_PERSON_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_RETURN_TERMS_TRANSFORMER, ReturnTermsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_TIME_DURATION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_RATING_HISTOGRAMS_TRANSFORMER, RatingHistogramsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_RATING_HISTOGRAM_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_REVIEW_RATING_TRANSFORMER, ReviewRatingTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_RATING_HISTOGRAMS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_SELLER_CUSTOM_POLICIES_TRANSFORMER, SellerCustomPoliciesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_SELLER_CUSTOM_POLICY_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_VAT_DETAILS_TRANSFORMER, VatDetailsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_VAT_DETAIL_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_SELLER_LEGAL_INFO_TRANSFORMER, SellerLegalInfoTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ECONOMIC_OPERATOR_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_LEGAL_ADDRESS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_VAT_DETAILS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_SELLER_TRANSFORMER, SellerTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_SELLER_LEGAL_INFO_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_SHIP_TO_REGIONS_TRANSFORMER, ShipToRegionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_SHIP_TO_REGION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_SHIP_TO_LOCATIONS_TRANSFORMER, ShipToLocationsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_SHIP_TO_REGIONS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_SHIPPING_OPTION_TRANSFORMER, ShippingOptionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SHIP_TO_LOCATION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_SHIPPING_OPTIONS_TRANSFORMER, ShippingOptionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_SHIPPING_OPTION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_TAX_JURISDICTION_TRANSFORMER, TaxJurisdictionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_REGION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_TAX_TRANSFORMER, TaxTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_TAX_JURISDICTION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_TAXES_TRANSFORMER, TaxesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_TAX_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_TYPED_NAME_VALUES_TRANSFORMER, TypedNameValuesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_TYPED_NAME_VALUE_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_DESCRIPTION_TRANSFORMER, ItemDescriptionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_TYPED_NAME_VALUES_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_CONDITION_TRANSFORMER, ItemConditionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CONDITION_DESCRIPTORS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_MEDIA_TRANSFORMER, ItemMediaTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGES_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_PRICING_TRANSFORMER, ItemPricingTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_AVAILABLE_COUPONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_MARKETING_PRICE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_PAYMENT_METHODS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_TAXES_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_FULFILMENT_TRANSFORMER, ItemFulfilmentTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ADDON_SERVICES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ESTIMATED_AVAILABILITIES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_LOCATION_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_RETURN_TERMS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SHIP_TO_LOCATIONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SHIPPING_OPTIONS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_LISTING_TRANSFORMER, ItemListingTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_AUTHENTICITY_GUARANTEE_PROGRAM_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_AUTHENTICITY_VERIFICATION_PROGRAM_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_CHARITY_TERMS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SELLER_CUSTOM_POLICIES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SELLER_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_PRODUCT_TRANSFORMER, ItemProductTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_GROUP_SUMMARY_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_PRODUCT_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_REVIEW_RATING_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_COMPLIANCE_TRANSFORMER, ItemComplianceTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_COMPANY_ADDRESS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ERRORS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_HAZARDOUS_MATERIALS_LABELS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_PRODUCT_SAFETY_LABELS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_RESPONSIBLE_PERSONS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_TRANSFORMER, ItemTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_DESCRIPTION_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_CONDITION_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_MEDIA_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_PRICING_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_FULFILMENT_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_LISTING_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_PRODUCT_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_COMPLIANCE_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEMS_TRANSFORMER, ItemsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_GROUP_TRANSFORMER, ItemGroupTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_COMMON_DESCRIPTIONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ERRORS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEMS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_PICKUP_OPTION_SUMMARIES_TRANSFORMER, PickupOptionSummariesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_PICKUP_OPTION_SUMMARY_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_SUMMARY_TRANSFORMER, ItemSummaryTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CATEGORIES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_COMPATIBILITY_PROPERTIES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_LOCATION_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_MARKETING_PRICE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_PICKUP_OPTION_SUMMARIES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SELLER_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SHIPPING_OPTIONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_TARGET_LOCATION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_SUMMARIES_TRANSFORMER, ItemSummariesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_SUMMARY_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEMS_RESPONSE_TRANSFORMER, ItemsResponseTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ERRORS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEMS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_REFINEMENT_TRANSFORMER, RefinementTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ASPECT_DISTRIBUTIONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_BUYING_OPTION_DISTRIBUTIONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_CATEGORY_DISTRIBUTIONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_CONDITION_DISTRIBUTIONS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_SEARCH_PAGED_COLLECTION_TRANSFORMER, SearchPagedCollectionTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_AUTO_CORRECTIONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ERRORS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_SUMMARIES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_REFINEMENT_TRANSFORMER),
                ]
            );
    }
}
