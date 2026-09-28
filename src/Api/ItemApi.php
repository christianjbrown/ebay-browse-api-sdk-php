<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\Exception\Response\BadResponseExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Auth\CredentialsInterface;
use ChristianBrown\EBay\Browse\Cache\KeyedCacheInterface;
use ChristianBrown\EBay\Browse\Exception\ItemNotFoundException;
use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Http\ApiHostInterface;
use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemGroupTransformerInterface;
use ChristianBrown\EBay\Browse\Transformer\ItemTransformerInterface;
use Throwable;

use function array_filter;
use function http_build_query;
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
     * @param JsonApiRequestSenderInterface           $requestSender        Sends every request this client makes
     * @param ItemTransformerInterface                $itemTransformer      Builds an ItemInterface from raw response data
     * @param ItemGroupTransformerInterface           $itemGroupTransformer Builds an ItemGroupInterface from raw response data
     * @param CredentialsInterface                    $credentials          Supplies the auth and marketplace headers
     * @param ApiHostInterface                        $apiHost              Resolves the Browse API base URL
     * @param KeyedCacheInterface<ItemInterface>      $oneCache             Keyed by getOneById()'s item id and query string
     * @param KeyedCacheInterface<ItemInterface>      $legacyCache          Keyed by getOneByLegacyId()'s query string
     * @param KeyedCacheInterface<ItemGroupInterface> $itemGroupCache       Keyed by getMultipleByItemGroupId()'s item group id
     */
    public function __construct(JsonApiRequestSenderInterface $requestSender, ItemTransformerInterface $itemTransformer, ItemGroupTransformerInterface $itemGroupTransformer, CredentialsInterface $credentials, ApiHostInterface $apiHost, KeyedCacheInterface $oneCache, KeyedCacheInterface $legacyCache, KeyedCacheInterface $itemGroupCache)
    {
        $this->requestSender = $requestSender;
        $this->itemTransformer = $itemTransformer;
        $this->itemGroupTransformer = $itemGroupTransformer;
        $this->credentials = $credentials;
        $this->apiHost = $apiHost;
        $this->oneCache = $oneCache;
        $this->legacyCache = $legacyCache;
        $this->itemGroupCache = $itemGroupCache;
    }

    /**
     * @throws ItemNotFoundException
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getMultipleByItemGroupId(string $itemGroupId, bool $skipCache = false): ItemGroupInterface
    {
        if (!$skipCache) {
            if ($this->itemGroupCache->has($itemGroupId)) {
                return $this->itemGroupCache->get($itemGroupId);
            }
        }

        $query = [self::KEY_ITEM_GROUP_ID => $itemGroupId];

        try {
            $data = $this->requestSender->get($this->apiHost->browseApiUrl(self::PATH_ITEMS_BY_ITEM_GROUP), $query, $this->credentials->toHeaders());
        } catch (BadResponseExceptionInterface $exception) {
            throw self::mapNotFound($exception, $itemGroupId);
        }

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $itemGroup = $this->itemGroupTransformer->transform($data);
        $this->itemGroupCache->set($itemGroupId, $itemGroup);

        return $itemGroup;
    }

    /**
     * @throws ItemNotFoundException
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneById(string $itemId, ?string $fieldgroups = null, bool $skipCache = false): ItemInterface
    {
        $query = self::buildFieldgroupsQuery($fieldgroups);
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
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function getOneByLegacyId(string $legacyItemId, ?string $legacyVariationId = null, ?string $legacyVariationSku = null, ?string $fieldgroups = null, bool $skipCache = false): ItemInterface
    {
        $query = self::buildLegacyQuery($legacyItemId, $legacyVariationId, $legacyVariationSku, $fieldgroups);
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
    private static function buildFieldgroupsQuery(?string $fieldgroups): array
    {
        // array_filter over a candidate map keeps this a single, branch-free
        // control-flow path regardless of how many optional parameters are set,
        // avoiding the combinatorial path explosion of sequential ifs.
        return array_filter(
            [
                self::KEY_FIELDGROUPS => $fieldgroups,
            ],
            static fn (?string $value): bool => null !== $value,
        );
    }

    /**
     * @return array<string, string>
     */
    private static function buildLegacyQuery(string $legacyItemId, ?string $legacyVariationId, ?string $legacyVariationSku, ?string $fieldgroups): array
    {
        return array_filter(
            [
                self::KEY_LEGACY_ITEM_ID => $legacyItemId,
                self::KEY_LEGACY_VARIATION_ID => $legacyVariationId,
                self::KEY_LEGACY_VARIATION_SKU => $legacyVariationSku,
                self::KEY_FIELDGROUPS => $fieldgroups,
            ],
            static fn (?string $value): bool => null !== $value,
        );
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
}
