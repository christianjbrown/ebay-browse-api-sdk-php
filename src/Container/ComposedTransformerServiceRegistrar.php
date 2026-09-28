<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoriesTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilityTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemSummariesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemSummaryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformer;
use ChristianBrown\EBay\Browse\Transformer\MarketingPriceTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandsTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodBrandTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodsTransformer;
use ChristianBrown\EBay\Browse\Transformer\PaymentMethodTransformer;
use ChristianBrown\EBay\Browse\Transformer\ProductTransformer;
use ChristianBrown\EBay\Browse\Transformer\RefinementTransformer;
use ChristianBrown\EBay\Browse\Transformer\ReturnTermsTransformer;
use ChristianBrown\EBay\Browse\Transformer\SearchPagedCollectionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ComposedTransformerServiceRegistrar implements ComposedTransformerServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
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

        $container->register(BrowseInterface::SERVICE_IMAGES_TRANSFORMER, ImagesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
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
                ]
            );

        $container->register(BrowseInterface::SERVICE_PAYMENT_METHODS_TRANSFORMER, PaymentMethodsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_PAYMENT_METHOD_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_PRODUCT_TRANSFORMER, ProductTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_RETURN_TERMS_TRANSFORMER, ReturnTermsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_TIME_DURATION_TRANSFORMER),
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
                ]
            );

        $container->register(BrowseInterface::SERVICE_SHIPPING_OPTIONS_TRANSFORMER, ShippingOptionsTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_SHIPPING_OPTION_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_TYPED_NAME_VALUES_TRANSFORMER, TypedNameValuesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_TYPED_NAME_VALUE_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_TRANSFORMER, ItemTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ERRORS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ESTIMATED_AVAILABILITIES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_LOCATION_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_MARKETING_PRICE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_PAYMENT_METHODS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_PRODUCT_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_RETURN_TERMS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SELLER_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SHIP_TO_LOCATIONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SHIPPING_OPTIONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_TYPED_NAME_VALUES_TRANSFORMER),
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

        $container->register(BrowseInterface::SERVICE_ITEM_SUMMARY_TRANSFORMER, ItemSummaryTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CATEGORIES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_IMAGES_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_LOCATION_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_MARKETING_PRICE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SELLER_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_SHIPPING_OPTIONS_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_SUMMARIES_TRANSFORMER, ItemSummariesTransformer::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_SUMMARY_TRANSFORMER),
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
