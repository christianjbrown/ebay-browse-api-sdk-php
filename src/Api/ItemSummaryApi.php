<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Api;

use ChristianBrown\ApiClient\Exception\Request\RequestExceptionInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Auth\CredentialsInterface;
use ChristianBrown\EBay\Browse\Cache\KeyedCacheInterface;
use ChristianBrown\EBay\Browse\Exception\MissingInputException;
use ChristianBrown\EBay\Browse\Exception\UnexpectedResponseException;
use ChristianBrown\EBay\Browse\Http\ApiHostInterface;
use ChristianBrown\EBay\Browse\Model\SearchPagedCollectionInterface;
use ChristianBrown\EBay\Browse\Transformer\SearchPagedCollectionTransformerInterface;

use function array_filter;
use function http_build_query;

final class ItemSummaryApi implements ItemSummaryApiInterface
{
    private ApiHostInterface $apiHost;

    /**
     * @var KeyedCacheInterface<SearchPagedCollectionInterface>
     */
    private KeyedCacheInterface $cache;
    private CredentialsInterface $credentials;
    private JsonApiRequestSenderInterface $requestSender;
    private SearchPagedCollectionTransformerInterface $searchPagedCollectionTransformer;

    /**
     * @param JsonApiRequestSenderInterface                       $requestSender                    Sends every request this client makes
     * @param SearchPagedCollectionTransformerInterface           $searchPagedCollectionTransformer Builds a SearchPagedCollectionInterface from raw response data
     * @param CredentialsInterface                                $credentials                      Supplies the auth and marketplace headers
     * @param ApiHostInterface                                    $apiHost                          Resolves the Browse API base URL
     * @param KeyedCacheInterface<SearchPagedCollectionInterface> $cache                            Keyed by search()'s query string
     */
    public function __construct(JsonApiRequestSenderInterface $requestSender, SearchPagedCollectionTransformerInterface $searchPagedCollectionTransformer, CredentialsInterface $credentials, ApiHostInterface $apiHost, KeyedCacheInterface $cache)
    {
        $this->requestSender = $requestSender;
        $this->searchPagedCollectionTransformer = $searchPagedCollectionTransformer;
        $this->credentials = $credentials;
        $this->apiHost = $apiHost;
        $this->cache = $cache;
    }

    /**
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function search(?string $q = null, ?string $gtin = null, ?string $charityIds = null, ?string $categoryIds = null, ?string $epid = null, ?string $aspectFilter = null, ?string $compatibilityFilter = null, ?string $filter = null, ?string $sort = null, ?string $fieldgroups = null, ?string $autoCorrect = null, int $limit = 50, int $offset = 0, bool $skipCache = false): SearchPagedCollectionInterface
    {
        $query = self::buildQuery($q, $gtin, $charityIds, $categoryIds, $epid, $aspectFilter, $compatibilityFilter, $filter, $sort, $fieldgroups, $autoCorrect, $limit, $offset);
        $cacheKey = http_build_query($query);
        if (!$skipCache) {
            if ($this->cache->has($cacheKey)) {
                return $this->cache->get($cacheKey);
            }
        }

        $data = $this->requestSender->get($this->apiHost->browseApiUrl(self::PATH_SEARCH), $query, $this->credentials->toHeaders());

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }
        $collection = $this->searchPagedCollectionTransformer->transform($data);
        $this->cache->set($cacheKey, $collection);

        return $collection;
    }

    /**
     * @param string $image A base64-encoded image
     *
     * @throws MissingInputException
     * @throws RequestExceptionInterface
     * @throws UnexpectedResponseException
     */
    public function searchByImage(string $image, ?string $charityIds = null, ?string $categoryIds = null, ?string $aspectFilter = null, ?string $filter = null, ?string $sort = null, ?string $fieldgroups = null, int $limit = 50, int $offset = 0): SearchPagedCollectionInterface
    {
        if (empty($image)) {
            throw new MissingInputException(self::MISSING_IMAGE);
        }

        // The image search takes the same refinement parameters as the keyword
        // search minus the keyword-only ones, which are passed as null here.
        $query = self::buildQuery(null, null, $charityIds, $categoryIds, null, $aspectFilter, null, $filter, $sort, $fieldgroups, null, $limit, $offset);
        $body = [self::KEY_IMAGE => $image];
        $data = $this->requestSender->post($this->apiHost->browseApiUrl(self::PATH_SEARCH_BY_IMAGE), $query, $this->credentials->toHeaders(), $body);

        if (empty($data)) {
            throw new UnexpectedResponseException(self::UNEXPECTED_RESPONSE);
        }

        return $this->searchPagedCollectionTransformer->transform($data);
    }

    /**
     * @return array<string, string>
     */
    private static function buildQuery(?string $q, ?string $gtin, ?string $charityIds, ?string $categoryIds, ?string $epid, ?string $aspectFilter, ?string $compatibilityFilter, ?string $filter, ?string $sort, ?string $fieldgroups, ?string $autoCorrect, int $limit, int $offset): array
    {
        // array_filter over a candidate map keeps this a single, branch-free
        // control-flow path regardless of how many of the eleven optional
        // parameters are set, avoiding the combinatorial path explosion that a
        // chain of sequential ifs would produce.
        return array_filter(
            [
                self::KEY_LIMIT => (string) $limit,
                self::KEY_OFFSET => (string) $offset,
                self::KEY_Q => $q,
                self::KEY_GTIN => $gtin,
                self::KEY_CHARITY_IDS => $charityIds,
                self::KEY_CATEGORY_IDS => $categoryIds,
                self::KEY_EPID => $epid,
                self::KEY_ASPECT_FILTER => $aspectFilter,
                self::KEY_COMPATIBILITY_FILTER => $compatibilityFilter,
                self::KEY_FILTER => $filter,
                self::KEY_SORT => $sort,
                self::KEY_FIELDGROUPS => $fieldgroups,
                self::KEY_AUTO_CORRECT => $autoCorrect,
            ],
            static fn (?string $value): bool => null !== $value,
        );
    }
}
