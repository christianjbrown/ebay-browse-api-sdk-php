# Changelog

All notable changes to this package are recorded here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the package uses
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.1] - 2026-10-01

### Changed

- The archive Composer installs no longer contains the tests, CI and editor configuration, `CLAUDE.md` or other development-only files, only the library itself, its README, CHANGELOG and LICENSE.

## [2.0.0] - 2026-10-01

### Added

- `BrowseFactory` and `BrowseFactoryInterface`, the composition root that builds the `Browse` facade:
  `(new BrowseFactory(ApiHost::production()))->create($clientId, $clientSecret, $marketplace, $store)`.
- Eight part transformers behind their own interfaces (`ItemDescriptionTransformer`,
  `ItemConditionTransformer`, `ItemMediaTransformer`, `ItemPricingTransformer`,
  `ItemFulfilmentTransformer`, `ItemListingTransformer`, `ItemProductTransformer` and
  `ItemComplianceTransformer`), registered in the container under new
  `BrowseInterface::SERVICE_ITEM_*_TRANSFORMER` ids.

### Changed

- Requires `christianjbrown/api-client` ^3.0, `christianjbrown/oauth2-client` ^2.1 and
  `christianjbrown/key-value-store` ^3.0, plus `psr/clock` and `symfony/clock`. Consumers now get those
  majors: build the token store with a clock, e.g. `new MemoryKeyValueStore(new NativeClock())`.
- `CoreServiceRegistrar` takes an `ApiClientInterface`, a `ClientCredentialsTokenManagerFactoryInterface`
  and a `LockInterface` (`BrowseFactory` passes `NullLock`). The token manager is built by the factory.
- The `Browse` constructor takes a PSR-11 `ContainerInterface` and builds nothing. Replace
  `new Browse($clientId, $clientSecret, $marketplace, $store, $apiHost)` with
  `(new BrowseFactory($apiHost))->create($clientId, $clientSecret, $marketplace, $store)`.
- The API host is required: pass `ApiHost::production()` where you used to omit it.
- `ItemTransformer` takes the eight part transformers instead of 29 nested transformers. Output is unchanged.
- `ItemApi` requires its `ItemsResponseTransformerInterface` and `getItems()` cache instead of
  building defaults, and `ApiClientServiceRegistrar` requires its `getItems()` cache.

### Removed

- `BrowseInterface::SERVICE_ACCESS_TOKEN_TRANSFORMER`: the OAuth2 library now builds its own transformer.

## [1.1.1] - 2026-09-30

### Changed

- Allows christianjbrown/key-value-store 2.0 as well as 1.x. Nothing this package uses from it changed.

## [1.1.0] - 2026-09-28

### Added

- `getItems()` on the item client, the bulk `GET /item` operation that reads up to 20 items or 10 item
  groups in one request. It is a Limited Release call for select partners and needs the
  `buy.item.bulk` OAuth scope, which the client requests for this one call only.
- The remaining Item fields eBay documents: `addonServices`, `authenticityGuarantee`,
  `authenticityVerification`, `availableCoupons`, `charityTerms`, `conditionDescriptors`,
  `ecoParticipationFee`, `gender`, `hazardousMaterialsLabels`, `inferredEpid`, `manufacturer`,
  `minimumPriceToBid`, `pattern`, `priceDisplayCondition`, `primaryItemGroup`,
  `primaryProductReviewRating`, `productFicheWebUrl`, `productSafetyLabels`, `qualifiedPrograms`,
  `quantityLimitPerBuyer`, `repairScore`, `reservePriceMet`, `responsiblePersons`,
  `sellerCustomPolicies`, `size`, `sizeSystem`, `sizeType`, `taxes`, `tyreLabelImageUrl` and `watchCount`.
- The remaining ItemSummary fields: `compatibilityMatch`, `compatibilityProperties`,
  `distanceFromPickupLocation`, `pickupOptions`, `priceDisplayCondition`, `qualifiedPrograms` and
  `tyreLabelImageUrl`.
- The remaining documented fields on Product, PaymentMethod, Seller and ShippingOption.
- `quantityForShippingEstimate` on `getOneById()`, `getOneByLegacyId()` and
  `getMultipleByItemGroupId()`.

All new arguments are optional and appended, so existing calls keep working.

## [1.0.0] - 2026-09-28

First stable release.

### Added

- `Browse`, an entry point for the eBay Browse API. The client is read-only and returns typed model
  objects rather than raw arrays.
- Item lookups by item id, by legacy id and by item group, keyword and image searches, and part
  compatibility checks.
- `estimatedAvailabilities`, which carries the sold and remaining quantities that replaced the retired
  Shopping API's `QuantitySold`.
- Application (client-credentials) OAuth2 authentication, with the access token fetched and cached in a
  `TtlAwareKeyValueStoreInterface` you supply.
- A `Marketplace` value object for the marketplace id, end-user context and `Accept-Language` headers.
- An optional, last `ApiHostInterface` constructor argument to choose the eBay environment, with
  production and sandbox presets.
- A single exception hierarchy, so callers do not depend on the underlying HTTP client.

[Unreleased]: https://github.com/christianjbrown/ebay-browse-api-sdk-php/compare/v2.0.1...HEAD
[2.0.1]: https://github.com/christianjbrown/ebay-browse-api-sdk-php/compare/v2.0.0...v2.0.1
[2.0.0]: https://github.com/christianjbrown/ebay-browse-api-sdk-php/compare/v1.1.1...v2.0.0
[1.1.1]: https://github.com/christianjbrown/ebay-browse-api-sdk-php/compare/v1.1.0...v1.1.1
[1.1.0]: https://github.com/christianjbrown/ebay-browse-api-sdk-php/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/christianjbrown/ebay-browse-api-sdk-php/releases/tag/v1.0.0
