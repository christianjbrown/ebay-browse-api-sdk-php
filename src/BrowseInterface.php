<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse;

use ChristianBrown\EBay\Browse\Api\ItemApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApiInterface;

interface BrowseInterface
{
    public const string OAUTH_TOKEN_URL = 'https://api.ebay.com/identity/v1/oauth2/token';
    public const string SERVICE_ACCESS_TOKEN_TRANSFORMER = 'ebay_browse.transformer.access_token_transformer';
    public const string SERVICE_API_CLIENT = 'ebay_browse.api_client';
    public const string SERVICE_APPLICATION_ACCESS_TOKEN_TRANSFORMER = 'ebay_browse.transformer.application_access_token_transformer';
    public const string SERVICE_ASPECT_DISTRIBUTION_TRANSFORMER = 'ebay_browse.transformer.aspect_distribution_transformer';
    public const string SERVICE_ASPECT_DISTRIBUTIONS_TRANSFORMER = 'ebay_browse.transformer.aspect_distributions_transformer';
    public const string SERVICE_ASPECT_VALUE_DISTRIBUTION_TRANSFORMER = 'ebay_browse.transformer.aspect_value_distribution_transformer';
    public const string SERVICE_ASPECT_VALUE_DISTRIBUTIONS_TRANSFORMER = 'ebay_browse.transformer.aspect_value_distributions_transformer';
    public const string SERVICE_AUTO_CORRECTIONS_TRANSFORMER = 'ebay_browse.transformer.auto_corrections_transformer';
    public const string SERVICE_BUYING_OPTION_DISTRIBUTION_TRANSFORMER = 'ebay_browse.transformer.buying_option_distribution_transformer';
    public const string SERVICE_BUYING_OPTION_DISTRIBUTIONS_TRANSFORMER = 'ebay_browse.transformer.buying_option_distributions_transformer';
    public const string SERVICE_CATEGORIES_TRANSFORMER = 'ebay_browse.transformer.categories_transformer';
    public const string SERVICE_CATEGORY_DISTRIBUTION_TRANSFORMER = 'ebay_browse.transformer.category_distribution_transformer';
    public const string SERVICE_CATEGORY_DISTRIBUTIONS_TRANSFORMER = 'ebay_browse.transformer.category_distributions_transformer';
    public const string SERVICE_CATEGORY_TRANSFORMER = 'ebay_browse.transformer.category_transformer';
    public const string SERVICE_CLIENT_CREDENTIALS_TOKEN_MANAGER = 'ebay_browse.client_credentials_token_manager';
    public const string SERVICE_COMMON_DESCRIPTION_TRANSFORMER = 'ebay_browse.transformer.common_description_transformer';
    public const string SERVICE_COMMON_DESCRIPTIONS_TRANSFORMER = 'ebay_browse.transformer.common_descriptions_transformer';
    public const string SERVICE_COMPATIBILITY_RESPONSE_TRANSFORMER = 'ebay_browse.transformer.compatibility_response_transformer';
    public const string SERVICE_CONDITION_DISTRIBUTION_TRANSFORMER = 'ebay_browse.transformer.condition_distribution_transformer';
    public const string SERVICE_CONDITION_DISTRIBUTIONS_TRANSFORMER = 'ebay_browse.transformer.condition_distributions_transformer';
    public const string SERVICE_CONVERTED_AMOUNT_TRANSFORMER = 'ebay_browse.transformer.converted_amount_transformer';
    public const string SERVICE_CREDENTIALS = 'ebay_browse.auth.credentials';
    public const string SERVICE_ERROR_PARAMETER_TRANSFORMER = 'ebay_browse.transformer.error_parameter_transformer';
    public const string SERVICE_ERROR_PARAMETERS_TRANSFORMER = 'ebay_browse.transformer.error_parameters_transformer';
    public const string SERVICE_ERROR_TRANSFORMER = 'ebay_browse.transformer.error_transformer';
    public const string SERVICE_ERRORS_TRANSFORMER = 'ebay_browse.transformer.errors_transformer';
    public const string SERVICE_ESTIMATED_AVAILABILITIES_TRANSFORMER = 'ebay_browse.transformer.estimated_availabilities_transformer';
    public const string SERVICE_ESTIMATED_AVAILABILITY_TRANSFORMER = 'ebay_browse.transformer.estimated_availability_transformer';
    public const string SERVICE_IMAGE_TRANSFORMER = 'ebay_browse.transformer.image_transformer';
    public const string SERVICE_IMAGES_TRANSFORMER = 'ebay_browse.transformer.images_transformer';
    public const string SERVICE_ITEM_API = 'ebay_browse.api.item_api';
    public const string SERVICE_ITEM_COMPATIBILITY_API = 'ebay_browse.api.item_compatibility_api';
    public const string SERVICE_ITEM_GROUP_TRANSFORMER = 'ebay_browse.transformer.item_group_transformer';
    public const string SERVICE_ITEM_LOCATION_TRANSFORMER = 'ebay_browse.transformer.item_location_transformer';
    public const string SERVICE_ITEM_SUMMARIES_TRANSFORMER = 'ebay_browse.transformer.item_summaries_transformer';
    public const string SERVICE_ITEM_SUMMARY_API = 'ebay_browse.api.item_summary_api';
    public const string SERVICE_ITEM_SUMMARY_TRANSFORMER = 'ebay_browse.transformer.item_summary_transformer';
    public const string SERVICE_ITEM_TRANSFORMER = 'ebay_browse.transformer.item_transformer';
    public const string SERVICE_ITEMS_TRANSFORMER = 'ebay_browse.transformer.items_transformer';
    public const string SERVICE_JSON_API_REQUEST_SENDER = 'ebay_browse.json_api_request_sender';
    public const string SERVICE_MARKETING_PRICE_TRANSFORMER = 'ebay_browse.transformer.marketing_price_transformer';
    public const string SERVICE_PAYMENT_METHOD_BRAND_TRANSFORMER = 'ebay_browse.transformer.payment_method_brand_transformer';
    public const string SERVICE_PAYMENT_METHOD_BRANDS_TRANSFORMER = 'ebay_browse.transformer.payment_method_brands_transformer';
    public const string SERVICE_PAYMENT_METHOD_TRANSFORMER = 'ebay_browse.transformer.payment_method_transformer';
    public const string SERVICE_PAYMENT_METHODS_TRANSFORMER = 'ebay_browse.transformer.payment_methods_transformer';
    public const string SERVICE_PRODUCT_TRANSFORMER = 'ebay_browse.transformer.product_transformer';
    public const string SERVICE_REFINEMENT_TRANSFORMER = 'ebay_browse.transformer.refinement_transformer';
    public const string SERVICE_RETURN_TERMS_TRANSFORMER = 'ebay_browse.transformer.return_terms_transformer';
    public const string SERVICE_SEARCH_PAGED_COLLECTION_TRANSFORMER = 'ebay_browse.transformer.search_paged_collection_transformer';
    public const string SERVICE_SELLER_TRANSFORMER = 'ebay_browse.transformer.seller_transformer';
    public const string SERVICE_SHIP_TO_LOCATIONS_TRANSFORMER = 'ebay_browse.transformer.ship_to_locations_transformer';
    public const string SERVICE_SHIP_TO_REGION_TRANSFORMER = 'ebay_browse.transformer.ship_to_region_transformer';
    public const string SERVICE_SHIP_TO_REGIONS_TRANSFORMER = 'ebay_browse.transformer.ship_to_regions_transformer';
    public const string SERVICE_SHIPPING_OPTION_TRANSFORMER = 'ebay_browse.transformer.shipping_option_transformer';
    public const string SERVICE_SHIPPING_OPTIONS_TRANSFORMER = 'ebay_browse.transformer.shipping_options_transformer';
    public const string SERVICE_STRINGS_TRANSFORMER = 'ebay_browse.transformer.strings_transformer';
    public const string SERVICE_TIME_DURATION_TRANSFORMER = 'ebay_browse.transformer.time_duration_transformer';
    public const string SERVICE_TYPED_NAME_VALUE_TRANSFORMER = 'ebay_browse.transformer.typed_name_value_transformer';
    public const string SERVICE_TYPED_NAME_VALUES_TRANSFORMER = 'ebay_browse.transformer.typed_name_values_transformer';

    public function getItemApi(): ItemApiInterface;

    public function getItemCompatibilityApi(): ItemCompatibilityApiInterface;

    public function getItemSummaryApi(): ItemSummaryApiInterface;
}
