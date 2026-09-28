<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityGuaranteeProgramTransformer;
use ChristianBrown\EBay\Browse\Transformer\AuthenticityVerificationProgramTransformer;
use ChristianBrown\EBay\Browse\Transformer\AutoCorrectionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompanyAddressTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityPropertyTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformer;
use ChristianBrown\EBay\Browse\Transformer\CouponConstraintTransformer;
use ChristianBrown\EBay\Browse\Transformer\EconomicOperatorTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardPictogramTransformer;
use ChristianBrown\EBay\Browse\Transformer\HazardStatementTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\LegalAddressTransformer;
use ChristianBrown\EBay\Browse\Transformer\PickupOptionSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductIdentityTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelPictogramTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductSafetyLabelStatementTransformer;
use ChristianBrown\EBay\Browse\Transformer\RatingHistogramTransformer;
use ChristianBrown\EBay\Browse\Transformer\RegionTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerCustomPolicyTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionTransformer;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformer;
use ChristianBrown\EBay\Browse\Transformer\TargetLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\TimeDurationTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValueTransformer;
use ChristianBrown\EBay\Browse\Transformer\VatDetailTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class LeafTransformerServiceRegistrar implements LeafTransformerServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(BrowseInterface::SERVICE_ASPECT_VALUE_DISTRIBUTION_TRANSFORMER, AspectValueDistributionTransformer::class);
        $container->register(BrowseInterface::SERVICE_AUTHENTICITY_GUARANTEE_PROGRAM_TRANSFORMER, AuthenticityGuaranteeProgramTransformer::class);
        $container->register(BrowseInterface::SERVICE_AUTHENTICITY_VERIFICATION_PROGRAM_TRANSFORMER, AuthenticityVerificationProgramTransformer::class);
        $container->register(BrowseInterface::SERVICE_AUTO_CORRECTIONS_TRANSFORMER, AutoCorrectionsTransformer::class);
        $container->register(BrowseInterface::SERVICE_BUYING_OPTION_DISTRIBUTION_TRANSFORMER, BuyingOptionDistributionTransformer::class);
        $container->register(BrowseInterface::SERVICE_CATEGORY_DISTRIBUTION_TRANSFORMER, CategoryDistributionTransformer::class);
        $container->register(BrowseInterface::SERVICE_CATEGORY_TRANSFORMER, CategoryTransformer::class);
        $container->register(BrowseInterface::SERVICE_COMPANY_ADDRESS_TRANSFORMER, CompanyAddressTransformer::class);
        $container->register(BrowseInterface::SERVICE_COMPATIBILITY_PROPERTY_TRANSFORMER, CompatibilityPropertyTransformer::class);
        $container->register(BrowseInterface::SERVICE_CONDITION_DISTRIBUTION_TRANSFORMER, ConditionDistributionTransformer::class);
        $container->register(BrowseInterface::SERVICE_CONVERTED_AMOUNT_TRANSFORMER, ConvertedAmountTransformer::class);
        $container->register(BrowseInterface::SERVICE_COUPON_CONSTRAINT_TRANSFORMER, CouponConstraintTransformer::class);
        $container->register(BrowseInterface::SERVICE_ECONOMIC_OPERATOR_TRANSFORMER, EconomicOperatorTransformer::class);
        $container->register(BrowseInterface::SERVICE_ERROR_PARAMETER_TRANSFORMER, ErrorParameterTransformer::class);
        $container->register(BrowseInterface::SERVICE_HAZARD_PICTOGRAM_TRANSFORMER, HazardPictogramTransformer::class);
        $container->register(BrowseInterface::SERVICE_HAZARD_STATEMENT_TRANSFORMER, HazardStatementTransformer::class);
        $container->register(BrowseInterface::SERVICE_IMAGE_TRANSFORMER, ImageTransformer::class);
        $container->register(BrowseInterface::SERVICE_ITEM_LOCATION_TRANSFORMER, ItemLocationTransformer::class);
        $container->register(BrowseInterface::SERVICE_LEGAL_ADDRESS_TRANSFORMER, LegalAddressTransformer::class);
        $container->register(BrowseInterface::SERVICE_PICKUP_OPTION_SUMMARY_TRANSFORMER, PickupOptionSummaryTransformer::class);
        $container->register(BrowseInterface::SERVICE_PRODUCT_IDENTITY_TRANSFORMER, ProductIdentityTransformer::class);
        $container->register(BrowseInterface::SERVICE_PRODUCT_SAFETY_LABEL_PICTOGRAM_TRANSFORMER, ProductSafetyLabelPictogramTransformer::class);
        $container->register(BrowseInterface::SERVICE_PRODUCT_SAFETY_LABEL_STATEMENT_TRANSFORMER, ProductSafetyLabelStatementTransformer::class);
        $container->register(BrowseInterface::SERVICE_RATING_HISTOGRAM_TRANSFORMER, RatingHistogramTransformer::class);
        $container->register(BrowseInterface::SERVICE_REGION_TRANSFORMER, RegionTransformer::class);
        $container->register(BrowseInterface::SERVICE_SELLER_CUSTOM_POLICY_TRANSFORMER, SellerCustomPolicyTransformer::class);
        $container->register(BrowseInterface::SERVICE_SHIP_TO_LOCATION_TRANSFORMER, ShipToLocationTransformer::class);
        $container->register(BrowseInterface::SERVICE_SHIP_TO_REGION_TRANSFORMER, ShipToRegionTransformer::class);
        $container->register(BrowseInterface::SERVICE_STRINGS_TRANSFORMER, StringsTransformer::class);
        $container->register(BrowseInterface::SERVICE_TARGET_LOCATION_TRANSFORMER, TargetLocationTransformer::class);
        $container->register(BrowseInterface::SERVICE_TIME_DURATION_TRANSFORMER, TimeDurationTransformer::class);
        $container->register(BrowseInterface::SERVICE_TYPED_NAME_VALUE_TRANSFORMER, TypedNameValueTransformer::class);
        $container->register(BrowseInterface::SERVICE_VAT_DETAIL_TRANSFORMER, VatDetailTransformer::class);
    }
}
