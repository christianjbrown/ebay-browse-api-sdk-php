# eBay Finding API

This is a simple PHP library for the [eBay's Finding API](https://developer.ebay.com/api-docs/user-guides/static/finding-user-guide-landing.html).

## Prerequisites

You will need [PHP](https://www.php.net/) 8.3 (or higher up to 9.0) and [Composer](https://getcomposer.org/).

## Installation

```bash
composer require christianjbrown/ebay-find-service-api
```

## Usage

```php
use ChristianBrown\JsonApiClient\JsonApiRequestSender;
use ChristianBrown\eBay\FindServiceApi\Endpoint\FindItemsAdvancedApi;
use ChristianBrown\eBay\FindServiceApi\Request\RequestMultipleApi;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemTransformer;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemsTransformer;
use ChristianBrown\eBay\FindServiceApi\Transformer\PaginationTransformer;
use GuzzleHttp\Client;

$clientId = getenv('EBAY_CLIENT_ID');
$sellerUsername = getenv('EBAY_SELLER_USERNAME');

$guzzleClient = new Client();
$requestSender = new JsonApiRequestSender($guzzleClient);

$paginationTransformer = new PaginationTransformer();
$requestMultipleApi = new RequestMultipleApi($requestSender, $paginationTransformer, $clientId);

$itemTransformer = new ItemTransformer();
$itemsTransformer = new ItemsTransformer($itemTransformer);

$findItemsAdvancedApi = new FindItemsAdvancedApi($requestMultipleApi, $itemsTransformer);
$resultSet = $findItemsAdvancedApi->getBySeller($sellerUsername);

$items = $resultSet->getObjects();
```