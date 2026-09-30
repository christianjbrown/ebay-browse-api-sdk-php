# Changelog

All notable changes to this package are recorded here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the package uses
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

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

[Unreleased]: https://github.com/christianjbrown/ebay-browse-api-sdk-php/compare/v1.1.0...HEAD
[1.1.0]: https://github.com/christianjbrown/ebay-browse-api-sdk-php/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/christianjbrown/ebay-browse-api-sdk-php/releases/tag/v1.0.0
