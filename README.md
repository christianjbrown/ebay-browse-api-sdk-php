# eBay Finding API

This is a simple PHP library for the [eBay's Finding API](https://developer.ebay.com/api-docs/user-guides/static/finding-user-guide-landing.html).

## Prerequisites

You will need [PHP](https://www.php.net/) 8.2 (or higher up to 9.0) and [Composer](https://getcomposer.org/).

## Installation

```bash
composer require christianjbrown/ebay-find-service-api
```

## Usage

```php
use ChristianBrown\JsonApiClient\RequestSender;
use ChristianBrown\eBay\FindServiceApi\Endpoint\FindItemsAdvancedApi;
use ChristianBrown\eBay\FindServiceApi\Request\RequestMultipleApi;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemTransformer;
use ChristianBrown\eBay\FindServiceApi\Transformer\ItemsTransformer;
use ChristianBrown\eBay\FindServiceApi\Transformer\JsonEndpointBadResponseTransformer;
use ChristianBrown\eBay\FindServiceApi\Transformer\PaginationTransformer;

$clientId = getenv('EBAY_CLIENT_ID');
$sellerUsername = getenv('EBAY_SELLER_USERNAME');

$badResponseTransformer = new JsonEndpointBadResponseTransformer();
$requestSender = new RequestSender($badResponseTransformer);
$paginationTransformer = new PaginationTransformer();
$requestMultipleApi = new RequestMultipleApi($requestSender, $paginationTransformer, $clientId);

$itemTransformer = new ItemTransformer();
$itemsTransformer = new ItemsTransformer($itemTransformer);

$findItemsAdvancedApi = new FindItemsAdvancedApi($requestMultipleApi, $itemsTransformer);
$resultSet = $findItemsAdvancedApi->getBySeller($sellerUsername);

$items = $resultSet->getObjects();
```