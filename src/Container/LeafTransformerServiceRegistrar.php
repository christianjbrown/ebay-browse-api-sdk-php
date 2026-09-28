<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AutoCorrectionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformer;
use ChristianBrown\EBay\Browse\Transformer\SellerTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionTransformer;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformer;
use ChristianBrown\EBay\Browse\Transformer\TimeDurationTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValueTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class LeafTransformerServiceRegistrar implements LeafTransformerServiceRegistrarInterface
{
    public function register(ContainerBuilder $container): void
    {
        $container->register(BrowseInterface::SERVICE_ASPECT_VALUE_DISTRIBUTION_TRANSFORMER, AspectValueDistributionTransformer::class);
        $container->register(BrowseInterface::SERVICE_AUTO_CORRECTIONS_TRANSFORMER, AutoCorrectionsTransformer::class);
        $container->register(BrowseInterface::SERVICE_BUYING_OPTION_DISTRIBUTION_TRANSFORMER, BuyingOptionDistributionTransformer::class);
        $container->register(BrowseInterface::SERVICE_CATEGORY_TRANSFORMER, CategoryTransformer::class);
        $container->register(BrowseInterface::SERVICE_CATEGORY_DISTRIBUTION_TRANSFORMER, CategoryDistributionTransformer::class);
        $container->register(BrowseInterface::SERVICE_STRINGS_TRANSFORMER, StringsTransformer::class);
        $container->register(BrowseInterface::SERVICE_ERROR_PARAMETER_TRANSFORMER, ErrorParameterTransformer::class);
        $container->register(BrowseInterface::SERVICE_CONDITION_DISTRIBUTION_TRANSFORMER, ConditionDistributionTransformer::class);
        $container->register(BrowseInterface::SERVICE_CONVERTED_AMOUNT_TRANSFORMER, ConvertedAmountTransformer::class);
        $container->register(BrowseInterface::SERVICE_IMAGE_TRANSFORMER, ImageTransformer::class);
        $container->register(BrowseInterface::SERVICE_ITEM_LOCATION_TRANSFORMER, ItemLocationTransformer::class);
        $container->register(BrowseInterface::SERVICE_TIME_DURATION_TRANSFORMER, TimeDurationTransformer::class);
        $container->register(BrowseInterface::SERVICE_SELLER_TRANSFORMER, SellerTransformer::class);
        $container->register(BrowseInterface::SERVICE_SHIP_TO_REGION_TRANSFORMER, ShipToRegionTransformer::class);
        $container->register(BrowseInterface::SERVICE_TYPED_NAME_VALUE_TRANSFORMER, TypedNameValueTransformer::class);
    }
}
