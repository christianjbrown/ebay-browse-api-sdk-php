<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\BadResponseExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Auth\CredentialsInterface;
use ChristianBrown\EBay\Browse\Cache\ArrayKeyedCache;
use ChristianBrown\EBay\Browse\Cache\KeyedCacheInterface;
use ChristianBrown\EBay\Browse\Exception\ItemNotFoundException;
use ChristianBrown\EBay\Browse\Exception\MissingInputException;
use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Http\ApiHostInterface;
use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ItemsResponseInterface;
use ChristianBrown\EBay\Browse\Transformer\ErrorParametersTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorParameterTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ErrorTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemsResponseTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemsResponseTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemsTransformer;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformer;
use Throwable;

use function array_filter;
use function count;
use function http_build_query;
use function implode;
use function rawurlencode;
use function sprintf;

final class ItemApi implements ItemApiInterface
{
    private ApiHostInterface $apiHost;
    private CredentialsInterface $credentials;

    /**
     * @var KeyedCacheInterface<ItemGroupInterface>
     */
    private KeyedCacheInterface $itemGroupCache;
    private ItemGroupTransformerInterface $itemGroupTransformer;

    /**
     * @var KeyedCacheInterface<ItemsResponseInterface>
     */
    private KeyedCacheInterface $itemsCache;
    private ItemsResponseTransformerInterface $itemsResponseTransformer;
    private ItemTransformerInterface $itemTransformer;

    /**
     * @var KeyedCacheInterface<ItemInterface>
     */
    private KeyedCacheInterface $legacyCache;

    /**
     * @var KeyedCacheInterface<ItemInterface>
     */
    private KeyedCacheInterface $oneCache;
    private JsonApiRequestSenderInterface $requestSender;

    /**
     * @param JsonApiRequestSenderInterface                    $requestSender            Sends every request this client makes
     * @param ItemTransformerInterface                         $itemTransformer          Builds an ItemInterface from raw response data
     * @param ItemGroupTransformerInterface                    $itemGroupTransformer     Builds an ItemGroupInterface from raw response data
     * @param CredentialsInterface                             $credentials              Supplies the auth and marketplace headers
     * @param ApiHostInterface                                 $apiHost                  Resolves the Browse API base URL
     * @param KeyedCacheInterface<ItemInterface>               $oneCache                 Keyed by getOneById()'s item id and query string
     * @param KeyedCacheInterface<ItemInterface>               $legacyCache              Keyed by getOneByLegacyId()'s query string
     * @param KeyedCacheInterface<ItemGroupInterface>          $itemGroupCache           Keyed by getMultipleByItemGroupId()'s item group id
     * @param null|ItemsResponseTransformerInterface           $itemsResponseTransformer Builds an ItemsResponseInterface from raw getItems() response data; defaults to the same transformer chain the container wires, so an existing caller that predates getItems() is unaffected
     * @param null|KeyedCacheInterface<ItemsResponseInterface> $itemsCache               Keyed by getItems()'s query string
     */
    public function __construct(JsonApiRequestSenderInterface $requestSender, ItemTransformerInterface $itemTransformer, ItemGroupTransformerInterface $itemGroupTransformer, CredentialsInterface $credentials, ApiHostInterface $apiHost, KeyedCacheInterface $oneCache, KeyedCacheInterface $legacyCache, KeyedCacheInterface $itemGroupCache, ?ItemsResponseTransformerInterface $itemsResponseTransformer = null, ?KeyedCacheInterface $itemsCache = null)
    {
        $this->requestSender = $requestSender;
        $this->itemTransformer = $itemTransformer;
        $this->itemGroupTransformer = $itemGroupTransformer;
        $this->credentials = $credentials;
        $this->apiHost = $apiHost;
        $this->oneCache = $oneCache;
        $this->legacyCache = $legacyCache;
        $this->itemGroupCache = $itemGroupCache;
        $this->itemsResponseTransformer = $itemsResponseTransformer ?? self::defaultItemsResponseTransformer($itemTransformer);
        $this->itemsCache = $itemsCache ?? self::defaultItemsCache();
    }

    /**
     * @param array<int, string> $itemIds
     * @param array<int, string> $itemGroupIds
     *
     * @throws ItemNotFoundException
     * @throws MissingInputException
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getItems(array $itemIds = [], array $itemGroupIds = [], ?int $quantityForShippingEstimate = null, bool $skipCache = false): ItemsResponseInterface
    {
        self::validateItemIdsAndItemGroupIds($itemIds, $itemGroupIds);
        self::validateQuantityForShippingEstimate($quantityForShippingEstimate);

        $query = self::buildItemsQuery($itemIds, $itemGroupIds, $quantityForShippingEstimate);
        $cacheKey = http_build_query($query);
        if (!$skipCache) {
            if ($this->itemsCache->has($cacheKey)) {
                return $this->itemsCache->get($cacheKey);
            }
        }

        try {
            $data = $this->requestSender->get($this->apiHost->browseApiUrl(self::PATH_ITEMS), $query, $this->credentials->toHeaders(self::SCOPE_BULK));
        } catch (BadResponseExceptionInterface $exception) {
            throw self::mapNotFound($exception, $cacheKey);
        }

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $itemsResponse = $this->itemsResponseTransformer->transform($data);
        $this->itemsCache->set($cacheKey, $itemsResponse);

        return $itemsResponse;
    }

    /**
     * @throws ItemNotFoundException
     * @throws MissingInputException
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getMultipleByItemGroupId(string $itemGroupId, bool $skipCache = false, ?int $quantityForShippingEstimate = null): ItemGroupInterface
    {
        self::validateQuantityForShippingEstimate($quantityForShippingEstimate);

        $query = self::buildItemGroupQuery($itemGroupId, $quantityForShippingEstimate);
        $cacheKey = http_build_query($query);
        if (!$skipCache) {
            if ($this->itemGroupCache->has($cacheKey)) {
                return $this->itemGroupCache->get($cacheKey);
            }
        }

        try {
            $data = $this->requestSender->get($this->apiHost->browseApiUrl(self::PATH_ITEMS_BY_ITEM_GROUP), $query, $this->credentials->toHeaders());
        } catch (BadResponseExceptionInterface $exception) {
            throw self::mapNotFound($exception, $itemGroupId);
        }

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $itemGroup = $this->itemGroupTransformer->transform($data);
        $this->itemGroupCache->set($cacheKey, $itemGroup);

        return $itemGroup;
    }

    /**
     * @throws ItemNotFoundException
     * @throws MissingInputException
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $itemId, ?string $fieldgroups = null, bool $skipCache = false, ?int $quantityForShippingEstimate = null): ItemInterface
    {
        self::validateQuantityForShippingEstimate($quantityForShippingEstimate);

        $query = self::buildFieldgroupsQuery($fieldgroups, $quantityForShippingEstimate);
        $cacheKey = sprintf('%s?%s', $itemId, http_build_query($query));
        if (!$skipCache) {
            if ($this->oneCache->has($cacheKey)) {
                return $this->oneCache->get($cacheKey);
            }
        }

        // The Browse API's item id contains pipes, so it has to be escaped
        // before it is interpolated into the path.
        $url = sprintf($this->apiHost->browseApiUrl(self::PATH_ITEM_SPRINTF), rawurlencode($itemId));

        try {
            $data = $this->requestSender->get($url, $query, $this->credentials->toHeaders());
        } catch (BadResponseExceptionInterface $exception) {
            throw self::mapNotFound($exception, $itemId);
        }

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $item = $this->itemTransformer->transform($data);
        $this->oneCache->set($cacheKey, $item);

        return $item;
    }

    /**
     * @throws ItemNotFoundException
     * @throws MissingInputException
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByLegacyId(string $legacyItemId, ?string $legacyVariationId = null, ?string $legacyVariationSku = null, ?string $fieldgroups = null, bool $skipCache = false, ?int $quantityForShippingEstimate = null): ItemInterface
    {
        self::validateQuantityForShippingEstimate($quantityForShippingEstimate);

        $query = self::buildLegacyQuery($legacyItemId, $legacyVariationId, $legacyVariationSku, $fieldgroups, $quantityForShippingEstimate);
        $cacheKey = http_build_query($query);
        if (!$skipCache) {
            if ($this->legacyCache->has($cacheKey)) {
                return $this->legacyCache->get($cacheKey);
            }
        }

        try {
            $data = $this->requestSender->get($this->apiHost->browseApiUrl(self::PATH_ITEM_BY_LEGACY_ID), $query, $this->credentials->toHeaders());
        } catch (BadResponseExceptionInterface $exception) {
            throw self::mapNotFound($exception, $legacyItemId);
        }

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $item = $this->itemTransformer->transform($data);
        $this->legacyCache->set($cacheKey, $item);

        return $item;
    }

    /**
     * @return array<string, string>
     */
    private static function buildFieldgroupsQuery(?string $fieldgroups, ?int $quantityForShippingEstimate): array
    {
        // array_filter over a candidate map keeps this a single, branch-free
        // control-flow path regardless of how many optional parameters are set,
        // avoiding the combinatorial path explosion of sequential ifs.
        return array_filter(
            [
                self::KEY_FIELDGROUPS => $fieldgroups,
                self::KEY_QUANTITY_FOR_SHIPPING_ESTIMATE => self::quantityForShippingEstimateQueryValue($quantityForShippingEstimate),
            ],
            static fn (?string $value): bool => null !== $value,
        );
    }

    /**
     * @return array<string, string>
     */
    private static function buildItemGroupQuery(string $itemGroupId, ?int $quantityForShippingEstimate): array
    {
        return array_filter(
            [
                self::KEY_ITEM_GROUP_ID => $itemGroupId,
                self::KEY_QUANTITY_FOR_SHIPPING_ESTIMATE => self::quantityForShippingEstimateQueryValue($quantityForShippingEstimate),
            ],
            static fn (?string $value): bool => null !== $value,
        );
    }

    /**
     * @param array<int, string> $itemIds
     * @param array<int, string> $itemGroupIds
     *
     * @return array<string, string>
     */
    private static function buildItemsQuery(array $itemIds, array $itemGroupIds, ?int $quantityForShippingEstimate): array
    {
        // Each candidate is resolved by its own small helper rather than an
        // inline ternary here, so this method stays a single, branch-free
        // path regardless of which of the three optional values are given —
        // the alternative multiplies into paths this function can never
        // legitimately reach (itemIds and itemGroupIds can never both be
        // empty or both be non-empty; validateItemIdsAndItemGroupIds()
        // already guarantees exactly one is set by the time this runs).
        return array_filter(
            [
                self::KEY_ITEM_IDS => self::joinedIds($itemIds),
                self::KEY_ITEM_GROUP_IDS => self::joinedIds($itemGroupIds),
                self::KEY_QUANTITY_FOR_SHIPPING_ESTIMATE => self::quantityForShippingEstimateQueryValue($quantityForShippingEstimate),
            ],
            static fn (?string $value): bool => null !== $value,
        );
    }

    /**
     * @return array<string, string>
     */
    private static function buildLegacyQuery(string $legacyItemId, ?string $legacyVariationId, ?string $legacyVariationSku, ?string $fieldgroups, ?int $quantityForShippingEstimate): array
    {
        return array_filter(
            [
                self::KEY_LEGACY_ITEM_ID => $legacyItemId,
                self::KEY_LEGACY_VARIATION_ID => $legacyVariationId,
                self::KEY_LEGACY_VARIATION_SKU => $legacyVariationSku,
                self::KEY_FIELDGROUPS => $fieldgroups,
                self::KEY_QUANTITY_FOR_SHIPPING_ESTIMATE => self::quantityForShippingEstimateQueryValue($quantityForShippingEstimate),
            ],
            static fn (?string $value): bool => null !== $value,
        );
    }

    /**
     * @return KeyedCacheInterface<ItemsResponseInterface>
     */
    private static function defaultItemsCache(): KeyedCacheInterface
    {
        /**
         * @var ArrayKeyedCache<ItemsResponseInterface> $itemsCache
         */
        $itemsCache = new ArrayKeyedCache();

        return $itemsCache;
    }

    /**
     * The same transformer chain ApiClientServiceRegistrar wires through the
     * container, built by hand so a caller who constructs ItemApi directly
     * (see README's "Wiring the clients") and predates getItems() keeps
     * working without passing one.
     */
    private static function defaultItemsResponseTransformer(ItemTransformerInterface $itemTransformer): ItemsResponseTransformerInterface
    {
        $errorsTransformer = new ErrorsTransformer(new ErrorTransformer(new ErrorParametersTransformer(new ErrorParameterTransformer()), new StringsTransformer()));

        return new ItemsResponseTransformer($errorsTransformer, new ItemsTransformer($itemTransformer));
    }

    /**
     * A comma-separated id list for the given ids, or null when there are
     * none — kept out of buildItemsQuery() so that method stays a single
     * straight-line path instead of branching once per candidate.
     *
     * @param array<int, string> $ids
     */
    private static function joinedIds(array $ids): ?string
    {
        if (empty($ids)) {
            return null;
        }

        return implode(',', $ids);
    }

    /**
     * Turns the API's 404 (an ended, deleted or simply unknown listing) into a
     * dedicated exception, so a caller can tell "this listing is gone" apart
     * from "the request failed". Anything else is handed back untouched.
     */
    private static function mapNotFound(BadResponseExceptionInterface $exception, string $itemId): Throwable
    {
        if (self::HTTP_STATUS_NOT_FOUND !== $exception->getResponse()->getStatusCode()) {
            return $exception;
        }

        return new ItemNotFoundException(sprintf(self::ITEM_NOT_FOUND_SPRINTF, $itemId), 0, $exception);
    }

    private static function quantityForShippingEstimateQueryValue(?int $quantityForShippingEstimate): ?string
    {
        if (null === $quantityForShippingEstimate) {
            return null;
        }

        return (string) $quantityForShippingEstimate;
    }

    /**
     * @param array<int, string> $itemIds
     * @param array<int, string> $itemGroupIds
     */
    /**
     * @param array<int, string> $itemIds
     * @param array<int, string> $itemGroupIds
     */
    private static function validateExactlyOneOfItemIdsOrItemGroupIds(array $itemIds, array $itemGroupIds): void
    {
        $hasItemIds = !empty($itemIds);
        $hasItemGroupIds = !empty($itemGroupIds);

        if ($hasItemIds === $hasItemGroupIds) {
            if ($hasItemIds) {
                throw new MissingInputException(self::BOTH_ITEM_IDS_AND_ITEM_GROUP_IDS_PROVIDED);
            }

            throw new MissingInputException(self::NEITHER_ITEM_IDS_NOR_ITEM_GROUP_IDS_PROVIDED);
        }
    }

    /**
     * @param array<int, string> $itemIds
     * @param array<int, string> $itemGroupIds
     */
    private static function validateItemIdsAndItemGroupIds(array $itemIds, array $itemGroupIds): void
    {
        // Split into three small, independently-branching helpers rather
        // than one method with every guard inline: nesting them here would
        // multiply into path combinations (e.g. "too many item ids" crossed
        // with "too many item group ids") that can never both be true, since
        // validateExactlyOneOfItemIdsOrItemGroupIds() already guarantees only
        // one of the two arrays is ever non-empty.
        self::validateExactlyOneOfItemIdsOrItemGroupIds($itemIds, $itemGroupIds);
        self::validateMaxItemGroupIds($itemGroupIds);
        self::validateMaxItemIds($itemIds);
    }

    /**
     * @param array<int, string> $itemGroupIds
     */
    private static function validateMaxItemGroupIds(array $itemGroupIds): void
    {
        if (count($itemGroupIds) > self::MAX_ITEM_GROUP_IDS) {
            throw new MissingInputException(sprintf(self::TOO_MANY_ITEM_GROUP_IDS_SPRINTF, self::MAX_ITEM_GROUP_IDS));
        }
    }

    /**
     * @param array<int, string> $itemIds
     */
    private static function validateMaxItemIds(array $itemIds): void
    {
        if (count($itemIds) > self::MAX_ITEM_IDS) {
            throw new MissingInputException(sprintf(self::TOO_MANY_ITEM_IDS_SPRINTF, self::MAX_ITEM_IDS));
        }
    }

    private static function validateQuantityForShippingEstimate(?int $quantityForShippingEstimate): void
    {
        if (null === $quantityForShippingEstimate) {
            return;
        }
        if ($quantityForShippingEstimate >= 1) {
            return;
        }

        throw new MissingInputException(self::INVALID_QUANTITY_FOR_SHIPPING_ESTIMATE);
    }
}
