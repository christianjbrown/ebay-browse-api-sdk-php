# eBay Browse API SDK

[![CI](https://github.com/christianjbrown/ebay-browse-api-sdk-php/actions/workflows/ci.yml/badge.svg)](https://github.com/christianjbrown/ebay-browse-api-sdk-php/actions/workflows/ci.yml) [![Packagist](https://img.shields.io/packagist/v/christianjbrown/ebay-browse-api-sdk)](https://packagist.org/packages/christianjbrown/ebay-browse-api-sdk) [![License](https://img.shields.io/packagist/l/christianjbrown/ebay-browse-api-sdk)](https://github.com/christianjbrown/ebay-browse-api-sdk-php/blob/main/LICENSE) [![PHP](https://img.shields.io/packagist/dependency-v/christianjbrown/ebay-browse-api-sdk/php)](https://packagist.org/packages/christianjbrown/ebay-browse-api-sdk)

A strongly-typed PHP client for the [eBay Browse API](https://developer.ebay.com/api-docs/buy/browse/overview.html). It reads eBay's public listing data — a single item, the items in a multi-variation listing, keyword and image searches, and part compatibility — returning plain, typed model objects rather than raw arrays.

The client is **read-only** and covers the whole public Browse surface. It authenticates with an application (client-credentials) OAuth2 token, so it needs no seller consent and no user token. Two things it does that a thin wrapper would not: it exposes `estimatedAvailabilities`, which carries the sold and remaining quantities that replaced the retired Shopping API's `QuantitySold`, and it turns eBay's "item not found" response into its own `ItemNotFoundException` so a caller can tell an ended listing apart from a failed request.

### Supported endpoints

| Resource | Client | Endpoint(s) | Returns |
| --- | --- | --- | --- |
| Items | `getItemApi()` | `GET /item/{item_id}`, `GET /item/get_item_by_legacy_id`, `GET /item/get_items_by_item_group` | `ItemInterface` / `ItemGroupInterface` |
| Item compatibility | `getItemCompatibilityApi()` | `POST /item/{item_id}/check_compatibility` | `CompatibilityResponseInterface` |
| Item summaries | `getItemSummaryApi()` | `GET /item_summary/search`, `POST /item_summary/search_by_image` | `SearchPagedCollectionInterface` |

## :heavy_check_mark: Prerequisites

- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/) 8.5 or higher (8.x)
- [Composer](https://getcomposer.org/)

:bulb: If you're on MacOS and have [Homebrew](https://brew.sh/), PHP and Composer will install with `brew install composer`.

## :building_construction: Installation

For your composer-enabled project:

```bash
composer require christianjbrown/ebay-browse-api-sdk
```

## :computer: Usage

The Browse API authenticates every request with an **application access token** — eBay's OAuth2 `client_credentials` grant against `https://api.ebay.com/identity/v1/oauth2/token`, scope `https://api.ebay.com/oauth/api_scope`. This client fetches and caches that token for you, so you supply only your app's **client id** and **client secret** from the [eBay developer program](https://developer.ebay.com/my/keys).

Every request also carries a **marketplace id** (`X-EBAY-C-MARKETPLACE-ID`), which decides the site the data comes from and the currency prices are quoted in. That, plus the optional `X-EBAY-C-ENDUSERCTX` and `Accept-Language` headers, lives in a small `Marketplace` value object.

You supply four things to the `Browse` entry point, plus an optional fifth:

- your app's **client id**,
- your app's **client secret**,
- a **`MarketplaceInterface`** naming the marketplace to read,
- a **`TtlAwareKeyValueStoreInterface`** to hold the current access token (an in-memory store is fine — tokens last two hours and are re-fetched as needed; a shared store just saves round-trips),
- optionally, an **`ApiHostInterface`** naming which eBay environment to call (see [Overriding the API host](#satellite-overriding-the-api-host)); production is the default.

```php
use ChristianBrown\EBay\Browse\Browse;
use ChristianBrown\EBay\Browse\Enums\MarketplaceId;
use ChristianBrown\EBay\Browse\Marketplace;
use ChristianBrown\KeyValueStore\MemoryKeyValueStore;

$browse = new Browse(
    'your-client-id',
    'your-client-secret',
    new Marketplace(MarketplaceId::EBAY_GB),   // optionally: end-user context, Accept-Language
    new MemoryKeyValueStore()
);

$itemApi = $browse->getItemApi();                    // ItemApiInterface
$itemSummaryApi = $browse->getItemSummaryApi();      // ItemSummaryApiInterface
$compatibilityApi = $browse->getItemCompatibilityApi(); // ItemCompatibilityApiInterface
```

### :satellite: Overriding the API host

Every request, including the OAuth2 token exchange, goes to eBay's production host by default. To
point the client at eBay's sandbox instead, pass `ApiHost::sandbox()` as the fifth argument:

```php
use ChristianBrown\EBay\Browse\Browse;
use ChristianBrown\EBay\Browse\Http\ApiHost;

$browse = new Browse(
    'your-sandbox-client-id',
    'your-sandbox-client-secret',
    new Marketplace(MarketplaceId::EBAY_GB),
    new MemoryKeyValueStore(),
    ApiHost::sandbox()
);
```

eBay runs the Buy APIs, including Browse, through a different sandbox gateway host than the rest of
the platform: `ApiHost::sandbox()` calls the Browse API on `apiz.sandbox.ebay.com` and the OAuth2
token endpoint on `api.sandbox.ebay.com`. `ApiHost::production()` is the default and calls both on
`api.ebay.com`. For any other host (a proxy, a mock server in tests), construct `new
ApiHost($browseApiBaseUrl, $oauthTokenUrl)` directly.

### :package: Reading one item

`getOneById()` takes a Browse item id (`v1|123456789012|0`); `getOneByLegacyId()` takes the plain numeric id you see in an eBay URL and optionally a variation id or SKU.

```php
$item = $itemApi->getOneByLegacyId('123456789012');   // ItemInterface

printf("%s — %s %s\n", $item->getTitle(), $item->getPrice()?->getValue(), $item->getPrice()?->getCurrency());
printf("Seller: %s (%s%% of %d)\n",
    $item->getSeller()?->getUsername(),
    $item->getSeller()?->getFeedbackPercentage(),
    $item->getSeller()?->getFeedbackScore()
);

// The quantity fields that replaced the retired Shopping API's QuantitySold.
foreach ($item->getEstimatedAvailabilities() as $availability) {
    printf("%s: %d sold, %d remaining\n",
        $availability->getEstimatedAvailabilityStatus(),   // IN_STOCK, OUT_OF_STOCK, …
        $availability->getEstimatedSoldQuantity(),
        $availability->getEstimatedRemainingQuantity()
    );
}
```

`fieldgroups` is passed straight through, so `getOneById($itemId, 'PRODUCT')` adds the catalogue product block, and the multi-variation parent of a listing is read with:

```php
$group = $itemApi->getMultipleByItemGroupId('987654321098');   // ItemGroupInterface

foreach ($group->getItems() as $variation) {
    printf("%s — %s\n", $variation->getItemId(), $variation->getTitle());
}
```

### :mag: Searching

`search()` exposes the full parameter set — keyword, GTIN, EPID, charity ids, category ids, aspect and compatibility filters, the general `filter` expression, `sort`, `fieldgroups`, `auto_correct`, and `limit`/`offset` pagination.

```php
$collection = $browse->getItemSummaryApi()->search(
    q: 'vintage film camera',
    categoryIds: '15230',
    filter: 'buyingOptions:{FIXED_PRICE},price:[1..25],priceCurrency:GBP',
    sort: 'price',
    fieldgroups: 'MATCHING_ITEMS,ASPECT_REFINEMENTS',
    limit: 25,
    offset: 0
);

printf("%d matches, showing %d\n", $collection->getTotal(), count($collection->getItemSummaries()));

foreach ($collection->getItemSummaries() as $summary) {
    printf("%s — %s %s\n", $summary->getTitle(), $summary->getPrice()?->getValue(), $summary->getPrice()?->getCurrency());
}

// Refinements come back when you ask for them via fieldgroups.
foreach ($collection->getRefinement()?->getAspectDistributions() ?? [] as $aspect) {
    printf("%s\n", $aspect->getLocalizedAspectName());
    foreach ($aspect->getAspectValueDistributions() as $value) {
        printf("  %s (%d)\n", $value->getLocalizedAspectValue(), $value->getMatchCount());
    }
}
```

:bulb: eBay only returns `itemSummaries` alongside refinements when `MATCHING_ITEMS` is one of the `fieldgroups`. Ask for `ASPECT_REFINEMENTS` on its own and you get the refinements and nothing else.

`searchByImage()` takes a base64-encoded image and the same refinement parameters:

```php
$collection = $browse->getItemSummaryApi()->searchByImage(
    base64_encode(file_get_contents('photo.jpg')),
    categoryIds: '15230',
    limit: 10
);
```

### :wrench: Part compatibility

`check()` takes a Browse item id and a map of compatibility aspect names to values. The accepted names vary by marketplace and category — eBay answers `11507` listing the ones it does not recognise.

```php
$response = $compatibilityApi->check('v1|236751498408|0', [
    'Car Make' => 'Honda',
    'Model' => 'Civic',
    'Engine' => '2.0',
]);

echo $response->getCompatibilityStatus(), "\n";   // COMPATIBLE, NOT_COMPATIBLE, UNDETERMINED
```

## :rotating_light: Error handling

Everything this library throws implements `ChristianBrown\EBay\Browse\Exception\ExceptionInterface`, so a single `catch` covers it all:

```php
use ChristianBrown\EBay\Browse\Exception\ExceptionInterface;

try {
    $item = $itemApi->getOneByLegacyId('210987654321');
} catch (ExceptionInterface $exception) {
    // Anything this library throws lands here.
}
```

There are three concrete types:

- **`ItemNotFoundException`** (extends `RuntimeException`) — eBay answered `404`: the listing has ended, was deleted, or never existed. Catch this on its own to tell "this listing is gone" apart from "the request failed"; the original response is kept as the exception's previous throwable.
- **`UnexpectedResponseException`** (extends `RuntimeException`) — the Browse API returned a body the client or a transformer couldn't parse (a missing or mis-typed field, an empty response).
- **`MissingInputException`** (extends `InvalidArgumentException`) — bad caller input, e.g. `check()` with no compatibility properties or `searchByImage()` with an empty image.

```php
use ChristianBrown\EBay\Browse\Exception\ItemNotFoundException;

try {
    $item = $itemApi->getOneByLegacyId($legacyItemId);
} catch (ItemNotFoundException) {
    // The listing has ended — not an error worth retrying.
}
```

All three live in `src/Exception/`. Other request-level failures (network errors, `400`s, throttling) surface as `RequestExceptionInterface` from [`christianjbrown/api-client`](https://github.com/christianjbrown/api-client-php), and token failures as `RequestExceptionInterface` from [`christianjbrown/oauth2-client`](https://github.com/christianjbrown/oauth2-client-php). Both are outside this library's exception hierarchy. A `BadResponseExceptionInterface` carries `getDecodedBody()`, which is where eBay's `errors` payload (its `errorId`, `domain`, `category`, `message` and `longMessage`) can be read.

Under the hood, `Browse` wires the clients, their transformer chains, and the OAuth machinery through a [Symfony dependency-injection](https://symfony.com/doc/current/components/dependency_injection.html) container. If you don't want the container, you can build the same chain by hand — as shown below.

<details id="wiring-the-clients">
<summary><strong>Wiring the clients</strong></summary>

Every client takes a request sender, its transformer chain, a `CredentialsInterface` and an `ApiHostInterface`. The credentials and the host are the same for all three, so they are built once:

```php
use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\EBay\Browse\Auth\ApplicationAccessTokenTransformer;
use ChristianBrown\EBay\Browse\Auth\Credentials;
use ChristianBrown\EBay\Browse\Enums\MarketplaceId;
use ChristianBrown\EBay\Browse\Http\ApiHost;
use ChristianBrown\EBay\Browse\Marketplace;
use ChristianBrown\KeyValueStore\MemoryKeyValueStore;
use ChristianBrown\OAuth2Client\ClientCredentialsTokenManager;
use ChristianBrown\OAuth2Client\Transformer\AccessTokenTransformer;

// Shared JSON request sender (wires Guzzle for you).
$requestSender = (new ApiClient())->getJsonApiRequestSender();

// ApiHost::production() talks to api.ebay.com; ApiHost::sandbox() switches
// every client and the token exchange below to eBay's sandbox gateway.
$apiHost = ApiHost::production();

// OAuth2 client-credentials machinery. The extra token transformer rewrites
// eBay's non-standard `token_type: "Application Access Token"` to `Bearer`
// before the shared OAuth2 transformer, which only knows `Bearer`, sees it.
$tokenManager = new ClientCredentialsTokenManager(
    $requestSender,
    new MemoryKeyValueStore(),
    new ApplicationAccessTokenTransformer(new AccessTokenTransformer()),
    $apiHost->oauthTokenUrl()
);

$credentials = new Credentials(
    $tokenManager,
    new Marketplace(MarketplaceId::EBAY_GB),
    'your-client-id',
    'your-client-secret'
);
```

The transformer chains are built bottom-up from the leaves, sharing one instance of each leaf across every branch that needs it — exactly as the container wires them. The compatibility client has the shortest chain:

```php
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApi;
use ChristianBrown\EBay\Browse\Transformer\CompatibilityResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformer;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformer;

$errorsTransformer = new ErrorsTransformer(
    new ErrorTransformer(
        new ErrorParametersTransformer(new ErrorParameterTransformer()),
        new StringsTransformer()
    )
);

$compatibilityApi = new ItemCompatibilityApi(
    $requestSender,
    new CompatibilityResponseTransformer($errorsTransformer),
    $credentials,
    $apiHost
);
```

`ItemTransformer` and `ItemSummaryTransformer` take the same treatment with a longer constructor — read the argument list off the class and hand each nested transformer in, in order. `ItemApi` and `ItemSummaryApi` take the same `$requestSender`, their own transformer chain, `$credentials` and `$apiHost`, plus one `KeyedCacheInterface` argument per independent cache they keep — `ItemSummaryApi` takes one (for `search()`), `ItemApi` takes three (for `getOneById()`, `getOneByLegacyId()` and `getMultipleByItemGroupId()`, in that order), each its own `ArrayKeyedCache` instance:

```php
use ChristianBrown\EBay\Browse\Api\ItemApi;
use ChristianBrown\EBay\Browse\Cache\ArrayKeyedCache;

$itemApi = new ItemApi(
    $requestSender,
    $itemTransformer,
    $itemGroupTransformer,
    $credentials,
    $apiHost,
    new ArrayKeyedCache(), // getOneById()
    new ArrayKeyedCache(), // getOneByLegacyId()
    new ArrayKeyedCache()  // getMultipleByItemGroupId()
);
```

The `Browse` facade's registrars under `src/Container/` (`LeafTransformerServiceRegistrar`, `ComposedTransformerServiceRegistrar`, `ApiClientServiceRegistrar`) are the canonical wiring if you need a reference.

</details>

## :page_facing_up: License

Released under the [MIT License](LICENSE).
