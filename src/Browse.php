<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Api\ItemApi;
use ChristianBrown\EBay\Browse\Api\ItemApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApi;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApi;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApiInterface;
use ChristianBrown\EBay\Browse\Auth\Credentials;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\AspectValueDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\AutoCorrectionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\BuyingOptionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoriesTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CategoryTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\CommonDescriptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConditionDistributionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ConvertedAmountTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilitiesTransformer;
use ChristianBrown\EBay\Browse\Transformer\EstimatedAvailabilityTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImagesTransformer;
use ChristianBrown\EBay\Browse\Transformer\ImageTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemLocationTransformer;
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
use ChristianBrown\EBay\Browse\Transformer\SellerTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShippingOptionTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToLocationsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ShipToRegionTransformer;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformer;
use ChristianBrown\EBay\Browse\Transformer\TimeDurationTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValuesTransformer;
use ChristianBrown\EBay\Browse\Transformer\TypedNameValueTransformer;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use ChristianBrown\OAuth2Client\ClientCredentialsTokenManager;
use ChristianBrown\OAuth2Client\Transformer\AccessTokenTransformer;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class Browse implements BrowseInterface
{
    private TtlAwareKeyValueStoreInterface $accessTokenStore;
    private string $clientId;
    private string $clientSecret;
    private ContainerBuilder $container;
    private MarketplaceInterface $marketplace;

    public function __construct(string $clientId, string $clientSecret, MarketplaceInterface $marketplace, TtlAwareKeyValueStoreInterface $accessTokenStore)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->marketplace = $marketplace;
        $this->accessTokenStore = $accessTokenStore;
        $this->container = new ContainerBuilder();
        $this->init();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getItemApi(): ItemApiInterface
    {
        /**
         * @var ItemApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_ITEM_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getItemCompatibilityApi(): ItemCompatibilityApiInterface
    {
        /**
         * @var ItemCompatibilityApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_ITEM_COMPATIBILITY_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getItemSummaryApi(): ItemSummaryApiInterface
    {
        /**
         * @var ItemSummaryApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_ITEM_SUMMARY_API);

        return $service;
    }

    private function init(): void
    {
        // Registration order matters: a service must be registered before
        // another service wires a reference to its definition, so core comes
        // first, then the transformer chains bottom-up, then the API clients.
        $this->registerCore();
        $this->registerLeafTransformers();
        $this->registerComposedTransformers();
        $this->registerApiClients();
    }

    private function registerApiClients(): void
    {
        $this->container->register(self::SERVICE_ITEM_API, ItemApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_ITEM_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ITEM_GROUP_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_CREDENTIALS),
                ]
            );

        $this->container->register(self::SERVICE_ITEM_COMPATIBILITY_API, ItemCompatibilityApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_COMPATIBILITY_RESPONSE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_CREDENTIALS),
                ]
            );

        $this->container->register(self::SERVICE_ITEM_SUMMARY_API, ItemSummaryApi::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->container->getDefinition(self::SERVICE_SEARCH_PAGED_COLLECTION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_CREDENTIALS),
                ]
            );
    }

    private function registerComposedTransformers(): void
    {
        $this->container->register(self::SERVICE_ASPECT_VALUE_DISTRIBUTIONS_TRANSFORMER, AspectValueDistributionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ASPECT_VALUE_DISTRIBUTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ASPECT_DISTRIBUTION_TRANSFORMER, AspectDistributionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ASPECT_VALUE_DISTRIBUTIONS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ASPECT_DISTRIBUTIONS_TRANSFORMER, AspectDistributionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ASPECT_DISTRIBUTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_BUYING_OPTION_DISTRIBUTIONS_TRANSFORMER, BuyingOptionDistributionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_BUYING_OPTION_DISTRIBUTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_CATEGORIES_TRANSFORMER, CategoriesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CATEGORY_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_CATEGORY_DISTRIBUTIONS_TRANSFORMER, CategoryDistributionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CATEGORY_DISTRIBUTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_COMMON_DESCRIPTION_TRANSFORMER, CommonDescriptionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_COMMON_DESCRIPTIONS_TRANSFORMER, CommonDescriptionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_COMMON_DESCRIPTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ERROR_PARAMETERS_TRANSFORMER, ErrorParametersTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ERROR_PARAMETER_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ERROR_TRANSFORMER, ErrorTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ERROR_PARAMETERS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ERRORS_TRANSFORMER, ErrorsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ERROR_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_COMPATIBILITY_RESPONSE_TRANSFORMER, CompatibilityResponseTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ERRORS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_CONDITION_DISTRIBUTIONS_TRANSFORMER, ConditionDistributionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CONDITION_DISTRIBUTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ESTIMATED_AVAILABILITY_TRANSFORMER, EstimatedAvailabilityTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ESTIMATED_AVAILABILITIES_TRANSFORMER, EstimatedAvailabilitiesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ESTIMATED_AVAILABILITY_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_IMAGES_TRANSFORMER, ImagesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_IMAGE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_MARKETING_PRICE_TRANSFORMER, MarketingPriceTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_METHOD_BRAND_TRANSFORMER, PaymentMethodBrandTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_IMAGE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_METHOD_BRANDS_TRANSFORMER, PaymentMethodBrandsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PAYMENT_METHOD_BRAND_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_METHOD_TRANSFORMER, PaymentMethodTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PAYMENT_METHOD_BRANDS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PAYMENT_METHODS_TRANSFORMER, PaymentMethodsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_PAYMENT_METHOD_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_PRODUCT_TRANSFORMER, ProductTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_IMAGE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_IMAGES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_RETURN_TERMS_TRANSFORMER, ReturnTermsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_TIME_DURATION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_SHIP_TO_REGIONS_TRANSFORMER, ShipToRegionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_SHIP_TO_REGION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_SHIP_TO_LOCATIONS_TRANSFORMER, ShipToLocationsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_SHIP_TO_REGIONS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_SHIPPING_OPTION_TRANSFORMER, ShippingOptionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_SHIPPING_OPTIONS_TRANSFORMER, ShippingOptionsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_SHIPPING_OPTION_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_TYPED_NAME_VALUES_TRANSFORMER, TypedNameValuesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_TYPED_NAME_VALUE_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ITEM_TRANSFORMER, ItemTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ERRORS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ESTIMATED_AVAILABILITIES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_IMAGE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_IMAGES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ITEM_LOCATION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_MARKETING_PRICE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PAYMENT_METHODS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_PRODUCT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_RETURN_TERMS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SELLER_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SHIP_TO_LOCATIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SHIPPING_OPTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_STRINGS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_TYPED_NAME_VALUES_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ITEMS_TRANSFORMER, ItemsTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ITEM_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ITEM_GROUP_TRANSFORMER, ItemGroupTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_COMMON_DESCRIPTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ERRORS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ITEMS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ITEM_SUMMARY_TRANSFORMER, ItemSummaryTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CATEGORIES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_CONVERTED_AMOUNT_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_IMAGE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_IMAGES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ITEM_LOCATION_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_MARKETING_PRICE_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SELLER_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_SHIPPING_OPTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_STRINGS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_ITEM_SUMMARIES_TRANSFORMER, ItemSummariesTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ITEM_SUMMARY_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_REFINEMENT_TRANSFORMER, RefinementTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_ASPECT_DISTRIBUTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_BUYING_OPTION_DISTRIBUTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_CATEGORY_DISTRIBUTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_CONDITION_DISTRIBUTIONS_TRANSFORMER),
                ]
            );

        $this->container->register(self::SERVICE_SEARCH_PAGED_COLLECTION_TRANSFORMER, SearchPagedCollectionTransformer::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_AUTO_CORRECTIONS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ERRORS_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_ITEM_SUMMARIES_TRANSFORMER),
                    $this->container->getDefinition(self::SERVICE_REFINEMENT_TRANSFORMER),
                ]
            );
    }

    private function registerCore(): void
    {
        $this->container->register(self::SERVICE_API_CLIENT, ApiClient::class);
        $this->container->register(self::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(self::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);

        $this->container->register(self::SERVICE_ACCESS_TOKEN_TRANSFORMER, AccessTokenTransformer::class);
        $this->container->register(self::SERVICE_CLIENT_CREDENTIALS_TOKEN_MANAGER, ClientCredentialsTokenManager::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->accessTokenStore,
                    $this->container->getDefinition(self::SERVICE_ACCESS_TOKEN_TRANSFORMER),
                    self::OAUTH_TOKEN_URL,
                ]
            );

        $this->container->register(self::SERVICE_CREDENTIALS, Credentials::class)
            ->setArguments(
                [
                    $this->container->getDefinition(self::SERVICE_CLIENT_CREDENTIALS_TOKEN_MANAGER),
                    $this->marketplace,
                    $this->clientId,
                    $this->clientSecret,
                ]
            );
    }

    private function registerLeafTransformers(): void
    {
        $this->container->register(self::SERVICE_ASPECT_VALUE_DISTRIBUTION_TRANSFORMER, AspectValueDistributionTransformer::class);
        $this->container->register(self::SERVICE_AUTO_CORRECTIONS_TRANSFORMER, AutoCorrectionsTransformer::class);
        $this->container->register(self::SERVICE_BUYING_OPTION_DISTRIBUTION_TRANSFORMER, BuyingOptionDistributionTransformer::class);
        $this->container->register(self::SERVICE_CATEGORY_TRANSFORMER, CategoryTransformer::class);
        $this->container->register(self::SERVICE_CATEGORY_DISTRIBUTION_TRANSFORMER, CategoryDistributionTransformer::class);
        $this->container->register(self::SERVICE_STRINGS_TRANSFORMER, StringsTransformer::class);
        $this->container->register(self::SERVICE_ERROR_PARAMETER_TRANSFORMER, ErrorParameterTransformer::class);
        $this->container->register(self::SERVICE_CONDITION_DISTRIBUTION_TRANSFORMER, ConditionDistributionTransformer::class);
        $this->container->register(self::SERVICE_CONVERTED_AMOUNT_TRANSFORMER, ConvertedAmountTransformer::class);
        $this->container->register(self::SERVICE_IMAGE_TRANSFORMER, ImageTransformer::class);
        $this->container->register(self::SERVICE_ITEM_LOCATION_TRANSFORMER, ItemLocationTransformer::class);
        $this->container->register(self::SERVICE_TIME_DURATION_TRANSFORMER, TimeDurationTransformer::class);
        $this->container->register(self::SERVICE_SELLER_TRANSFORMER, SellerTransformer::class);
        $this->container->register(self::SERVICE_SHIP_TO_REGION_TRANSFORMER, ShipToRegionTransformer::class);
        $this->container->register(self::SERVICE_TYPED_NAME_VALUE_TRANSFORMER, TypedNameValueTransformer::class);
    }
}
