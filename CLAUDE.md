# CLAUDE.md

Guidance for working in this repository. Match the existing conventions exactly — this codebase is
large but uniform and highly opinionated, so new code should be indistinguishable from what's here.

## What this is

A strongly-typed, **read-only** PHP 8.5+ client for the
[eBay Browse API](https://developer.ebay.com/api-docs/buy/browse/overview.html). It reads a single
item, the items in a multi-variation listing, keyword and image searches, and part compatibility,
returning typed model objects instead of raw arrays. The primary entry point is the `Browse` facade
(`src/Browse.php`), which wires the clients and their transformer chains through a Symfony
`ContainerBuilder`. Hand-wiring the same chains without the container is still fully supported (see
the "Wiring the clients" section of `README.md`).

Two things matter more than the rest of the surface and must not regress:

- **`EstimatedAvailability`** carries `estimatedSoldQuantity`, `estimatedAvailableQuantity`,
  `estimatedRemainingQuantity` and `estimatedAvailabilityStatus`. These replaced the retired
  Shopping API's `QuantitySold` and are the reason downstream callers use this library at all.
- **`ItemNotFoundException`** is thrown for a `404` from any item endpoint, so a caller can tell an
  ended listing apart from a failed request. It must never collapse into a generic error.

## Commands

Binaries install into `bin/` (Composer `bin-dir`), not `vendor/bin/`. Both `bin/` and `vendor/` are
gitignored and Composer-installed, so run `composer install` first.

| Task | Command |
| --- | --- |
| Run tests + coverage (opens HTML report) | `composer test` |
| Run tests, no coverage | `php -d memory_limit=-1 ./bin/phpunit --no-coverage` |
| Run one test | `php -d memory_limit=-1 ./bin/phpunit --filter ItemTransformerTest` |
| Static analysis | `composer stan` |
| Check code style | `composer check-style` |
| Auto-fix code style | `composer fix-style` |
| Check / fix style on git diff only | `composer check-style-diff` / `composer fix-style-diff` |

After adding autoloadable files, run `composer dump-autoload` if the class isn't found.

Style tooling comes from the `christianjbrown/code-quality-scripts` dev dependency: `check-style`
lints with **PHP_CodeSniffer 4** using the **`ChristianBrown` standard** (slevomat sniffs plus
PSR/PEAR/Squiz/Generic), and **php-cs-fixer** (`@PhpCsFixer`/`@Symfony`) handles formatting; the
`bin/php-cs*` scripts are thin wrappers over it. Static analysis is **PHPStan at `level: max`**
(`phpstan.neon.dist`). Note the `--memory-limit=1G` in the `stan` script and in CI: this project has
enough files that PHPStan's parallel workers exhaust the default 128M on a cold cache. There is a
**GitHub Actions CI workflow** (`.github/workflows/ci.yml`) that runs style, PHPStan and the PHPUnit
suite with coverage on every push/PR; every dependency is a public GitHub repository, so it needs no
`COMPOSER_AUTH`. After the coverage run, a final **"Enforce 100% coverage"** step runs
`./bin/php-coverage-check .phpunit.cache/coverage.txt` (from `christianjbrown/code-quality-scripts`)
against the text report the previous step wrote, and fails the build if anything is below 100%. Run
the same two commands locally before pushing:
`XDEBUG_MODE=coverage php -d memory_limit=-1 ./bin/phpunit --coverage-text=.phpunit.cache/coverage.txt`
then `./bin/php-coverage-check .phpunit.cache/coverage.txt`. Always run `composer fix-style` first
(php-cs-fixer auto-fixes what it can), then `composer check-style` to surface any remaining
violations that must be fixed by hand, then `composer stan` and `composer test` before finishing.

## Architecture

Layers under `src/`, mirrored 1:1 under `tests/`, plus the top-level `Browse` facade. PSR-4:
`ChristianBrown\EBay\Browse\` → `src/`, `ChristianBrown\EBay\Browse\Tests\` → `tests/`. Note the
StudlyCase `EBay`.

- **`Browse`** (`src/Browse.php`) — the facade/entry point. Constructed with a client id, a client
  secret, a `MarketplaceInterface`, a `TtlAwareKeyValueStoreInterface` for the access token and an
  optional `ApiHostInterface` (defaults to `ApiHost::production()`), it builds a list of
  `ServiceRegistrarInterface` registrars and hands them to a `ContainerFactory`
  (`src/Container/ContainerFactory.php`), which runs each in order against one Symfony
  `ContainerBuilder` and returns it. Service ids live on `BrowseInterface` as `SERVICE_*` constants.
  `Browse` exposes `getItemApi()`, `getItemCompatibilityApi()` and `getItemSummaryApi()` by asking
  the built container for those services. The registrars, under `src/Container/`, run in dependency
  order — a service must exist before another registrar references its definition:
  `CoreServiceRegistrar` (credentials and the OAuth2 machinery), `LeafTransformerServiceRegistrar`,
  `ComposedTransformerServiceRegistrar`, then `ApiClientServiceRegistrar`. Adding a new API group
  means adding one more registrar to the list `Browse` builds, not editing an existing one.
- **`Http/ApiHost`** (`src/Http/ApiHostInterface.php`, `src/Http/ApiHost.php`) — the value object
  behind the optional fifth `Browse` constructor argument. `ApiHost::production()` (the default) and
  `ApiHost::sandbox()` are named constructors; `browseApiUrl(string $path)` and `oauthTokenUrl()` are
  the two things every `Api` client and `CoreServiceRegistrar` ask it for. The `API_URL_*` constants
  on `ItemApiInterface`/`ItemSummaryApiInterface`/`ItemCompatibilityApiInterface` and
  `BrowseInterface::OAUTH_TOKEN_URL` stay for backward compatibility but are no longer read
  internally — the corresponding `PATH_*` constants on each `Api` interface, resolved through the
  injected `ApiHostInterface`, are what the clients actually call.
- **`Marketplace`** (`src/Marketplace.php`) — a small value object holding a `MarketplaceId` enum
  case plus the optional end-user context and `Accept-Language`. `toHeaders()` builds
  `X-EBAY-C-MARKETPLACE-ID`, `X-EBAY-C-ENDUSERCTX` and `Accept-Language`.
- **`Auth/`** — `Credentials` resolves an application (client-credentials) OAuth2 token through
  `christianjbrown/oauth2-client`'s `ClientCredentialsTokenManager` and merges the bearer header
  with the marketplace headers. `ApplicationAccessTokenTransformer` sits in front of the shared
  `AccessTokenTransformer` and rewrites eBay's non-standard
  `token_type: "Application Access Token"` to `Bearer`, which is the only type the shared library
  models; without it every token exchange fails.
- **`Api/`** — HTTP clients (`ItemApi`, `ItemCompatibilityApi`, `ItemSummaryApi`). Each is
  constructed with a `JsonApiRequestSenderInterface` (from `christianjbrown/api-client` — no
  Guzzle/PSR-18 used directly), its transformer(s) and a `CredentialsInterface`. They send the
  credential headers, defensively validate the response shape, delegate to the transformer and
  return a typed model. Clients cache by request (`ItemApi` by item id plus query string,
  `ItemSummaryApi::search` by query string); `searchByImage` is deliberately uncached.
  **POSTs must set `Content-Type: application/json` themselves** — the shared request sender does
  not, and eBay answers `2005 Unsupported or not specified media type` without it.
  **404 handling**: each item client wraps its request in `try`/`catch (BadResponseExceptionInterface)`
  and passes the exception to a stateless `mapNotFound()`, which returns an `ItemNotFoundException`
  for `HTTP_STATUS_NOT_FOUND` and hands anything else straight back to be rethrown untouched.
- **`Transformer/`** — turn raw decoded-JSON arrays into `Model` objects. Nested transformers are
  constructor-injected and composed into a chain (e.g. `SearchPagedCollectionTransformer` →
  `ItemSummariesTransformer` → `ItemSummaryTransformer` → … → leaf). Collection transformers carry
  the plural name (`ImagesTransformer`, `CategoriesTransformer`). `StringsTransformer` is the shared
  leaf for plain string arrays (`buyingOptions`, `deliveryOptions`, `leafCategoryIds`).
- **`Model/`** — plain, mutable typed DTOs with getters and fluent setters.
- **`Enums/`** — `MarketplaceId`, the backed enum of eBay's marketplace ids.
- **`Exception/`** — `final` exception classes + matching interfaces: `ItemNotFoundException` and
  `UnexpectedResponseException` (both extend `RuntimeException`) and `MissingInputException`
  (extends `InvalidArgumentException`).

## Conventions (follow all of these)

- `declare(strict_types=1);` on every file, immediately after `<?php`.
- **Every concrete class is `final` and implements a matching `...Interface`** in the same namespace
  (`ItemApi`/`ItemApiInterface`, `ItemTransformer`/`ItemTransformerInterface`). No abstract base
  classes — composition over inheritance.
- **Constants live on the interface, not the class**: URLs, JSON keys (`KEY_*`), header names and
  sprintf message templates (`*_SPRINTF`). Parameterized URLs use `API_URL*_SPRINTF`. E.g.
  `ItemApiInterface::API_URL_ITEM_SPRINTF`, `ItemTransformerInterface::KEY_ITEM_ID`,
  `UNEXPECTED_STRING_SPRINTF`.
- **No constructor property promotion** — declare typed `private` properties and assign them in the
  constructor body. Class members (properties and methods) are ordered **alphabetically**.
- Import functions with `use function is_array;` etc. (after class imports, blank line between), and
  call them unqualified.
- **Models**: required fields are constructor args; optionals default (`?string $title = null`,
  `array $shippingOptions = []`). Getters `getX()`; fluent setters `setX($value)` (param literally
  `$value`) that `return $this` typed as the **interface**
  (`setTitle(?string $value): ItemInterface`). No `readonly`, no immutability.
- **Transformers**: one `transform(array $data): ...` method. Object transformers return a model
  interface; collection transformers (plural names) return `array`, looping with an indexed `for`
  over `array_values($data)` and delegating to the singular transformer. Guard required fields with
  a presence check then a **separate** type check (`is_string`/`is_int`/`is_bool`/`is_array`), each
  throwing its own `UnexpectedResponseException(sprintf(self::..._SPRINTF, self::KEY_...))`. Use
  `empty()` for the presence check on string/array fields, but **`isset()` for numeric and boolean
  fields** so a legitimate `0`/`false` isn't rejected as "not set". Optional fields are applied by
  one `applyX()` method each and are **silently skipped** when absent or wrong-typed. Type coercion
  (`strtotime()` for the ISO 8601 date fields, which become `?int` timestamps) happens here.
- **Avoid `foreach` and compound `&&`/`||` in `src/`.** Use indexed `for` loops and sequential `if`
  guards that `return`/`throw`. This is what keeps 100% **path** coverage reachable under xdebug.
  Two corollaries that already bit this codebase: a chain of sequential `if`s that all fall through
  multiplies into 2^n paths, so optional query parameters and headers are assembled into a candidate
  map and passed through `array_filter(..., static fn (?string $value): bool => null !== $value)`
  instead (see `ItemSummaryApi::buildQuery`, `Marketplace::toHeaders`); and a fixed-size `for` loop
  over an argument that is guaranteed non-empty adds an unreachable "loop not entered" path, so use
  `array_map` there instead (see `ItemCompatibilityApi::buildProperties`).
- **A method that does not use `$this` must be `static`** (called via `self::`) — a stateless helper
  is static. Enforced for private methods by the shared `RequireStaticPrivateMethodRule` PHPStan
  rule (via `code-quality-scripts`' `config/phpstan.neon`); interface/override methods stay instance.
  Note `TestCase::createMock()` is **not** static, so a test helper that mocks cannot be `static`
  (unlike one that only uses `createStub()`).
- **Exceptions live in `src/Exception/`**, each a `final` class + matching `...Interface`. Every
  exception interface extends the library-wide `ExceptionInterface` (which extends `Throwable`), so
  a single `catch (ExceptionInterface)` covers everything this library throws while dependency
  exceptions bubble up. Message text stays in `KEY_*`/`*_SPRINTF`/message constants on the relevant
  `Api`/`Transformer` interface — the exception classes carry no constants. Public methods that can
  throw carry `@throws` docblocks naming the concrete exception(s).

## Testing

The `phpunit.xml` config is strict (`requireCoverageMetadata`, `beStrictAboutCoverageMetadata`,
`failOnRisky`, `failOnWarning`, path coverage). With that in mind:

- **Coverage must stay at 100%** — classes, methods, lines, branches **and paths**. Every code path,
  including each defensive guard and every optional-field branch in the transformers, must be
  exercised. **Always run `composer test` and check the coverage report** before finishing — it
  prints a text summary to stdout and writes HTML to `.phpunit.cache/code-coverage-html/index.html`.
  New code without full coverage is not done.
- **Every test class needs a `#[CoversClass(...)]` attribute** or the run fails, and
  `beStrictAboutCoverageMetadata` also fails any test that touches a class it neither covers nor
  declares with `#[UsesClass(...)]`. In practice: a transformer test carries
  `#[CoversClass(TheModel::class)]` **and** `#[CoversClass(TheModelTransformer::class)]` because
  `transform()` constructs the model; `BrowseTest` carries `#[CoversClass(Browse::class)]` plus a
  `#[UsesClass]` line for every service the container instantiates. Use PHPUnit attributes, not
  annotations: `#[CoversClass]`, `#[UsesClass]`, `#[DataProvider]`, `#[TestWith]`.
- Tests mirror `src/` 1:1 under `tests/<Layer>/`, one `final class XTest extends TestCase` per
  class, methods named `test<Method><Scenario>`.
- `self::createStub(...)` for pure return-value doubles; `self::createMock(...)` with `expects()`
  only where the interaction itself is the thing under test. Assert statically (`self::assertSame`).
  Reference the **same interface constants** production code uses — for both data keys and expected
  exception messages — so no strings are hardcoded.
- The transformer tests are the template for exhaustive coverage: a `testTransform` with every field
  populated, a `provideTransformOptionalFieldStatesCases` data provider covering each optional
  field's absent / wrong-type / zero / false / unparseable-date states, and a
  `testTransformThrowsOnInvalidX` per required field with `#[TestWith]` for both the missing and the
  mis-typed case. Collection transformer tests cover empty, single, many, an immediately-invalid
  element and a later-invalid element — the last two are separate paths.
- All tests are unit tests with no network access.

## Adding a feature (e.g. a new response field or endpoint)

1. Confirm the real shape against the live API first — model on the JSON eBay actually returns, not
   on the documentation. Use your own eBay application's client id and secret, supplied at run time;
   never commit or print a secret.
2. Add the `Model` DTO + its interface (constants, if any, on the interface).
3. Add the `Transformer` + its interface, with `KEY_*` and `*_SPRINTF` constants on the interface,
   plus a plural collection transformer if the field is a list.
4. Wire the new transformer into its parent transformer's constructor, keeping the constructor
   arguments alphabetical.
5. Register the new services on `BrowseInterface` (`SERVICE_*`) and in the matching
   `registerLeafTransformers()` / `registerComposedTransformers()` method of `Browse`, after
   anything they depend on.
6. If it's a new endpoint, extend/add the `Api` client and its interface (`API_URL*` constant), and
   remember the `Content-Type` header if it POSTs.
7. Add matching tests under `tests/<Layer>/`, and a `#[UsesClass]` line in `BrowseTest` for any new
   service the container builds.
8. Run `composer fix-style`, then `composer check-style`, then `composer stan`, then `composer test`
   and **confirm the coverage report is 100%** on classes, methods, lines, branches and paths.
