<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use ChristianBrown\EBay\Browse\Api\ItemApi;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApi;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApi;
use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Cache\KeyedCacheInterface;
use ChristianBrown\EBay\Browse\Http\ApiHostInterface;
use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\SearchPagedCollectionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ApiClientServiceRegistrar implements ApiClientServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    /**
     * @var KeyedCacheInterface<ItemGroupInterface>
     */
    private KeyedCacheInterface $itemGroupCache;

    /**
     * @var KeyedCacheInterface<ItemInterface>
     */
    private KeyedCacheInterface $itemLegacyCache;

    /**
     * @var KeyedCacheInterface<ItemInterface>
     */
    private KeyedCacheInterface $itemOneCache;

    /**
     * @var KeyedCacheInterface<SearchPagedCollectionInterface>
     */
    private KeyedCacheInterface $itemSummarySearchCache;

    /**
     * One cache instance per independent cache key shape: ItemApi alone
     * caches three different ways (by id, by legacy id, by item group id),
     * so each needs its own instance rather than sharing one across
     * unrelated key spaces.
     *
     * @param ApiHostInterface                                    $apiHost                Resolves the Browse API base URL
     * @param KeyedCacheInterface<ItemInterface>                  $itemOneCache
     * @param KeyedCacheInterface<ItemInterface>                  $itemLegacyCache
     * @param KeyedCacheInterface<ItemGroupInterface>             $itemGroupCache
     * @param KeyedCacheInterface<SearchPagedCollectionInterface> $itemSummarySearchCache
     */
    public function __construct(ApiHostInterface $apiHost, KeyedCacheInterface $itemOneCache, KeyedCacheInterface $itemLegacyCache, KeyedCacheInterface $itemGroupCache, KeyedCacheInterface $itemSummarySearchCache)
    {
        $this->apiHost = $apiHost;
        $this->itemOneCache = $itemOneCache;
        $this->itemLegacyCache = $itemLegacyCache;
        $this->itemGroupCache = $itemGroupCache;
        $this->itemSummarySearchCache = $itemSummarySearchCache;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(BrowseInterface::SERVICE_ITEM_API, ItemApi::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_ITEM_GROUP_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_CREDENTIALS),
                    $this->apiHost,
                    $this->itemOneCache,
                    $this->itemLegacyCache,
                    $this->itemGroupCache,
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_COMPATIBILITY_API, ItemCompatibilityApi::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(BrowseInterface::SERVICE_COMPATIBILITY_RESPONSE_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_CREDENTIALS),
                    $this->apiHost,
                ]
            );

        $container->register(BrowseInterface::SERVICE_ITEM_SUMMARY_API, ItemSummaryApi::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $container->getDefinition(BrowseInterface::SERVICE_SEARCH_PAGED_COLLECTION_TRANSFORMER),
                    $container->getDefinition(BrowseInterface::SERVICE_CREDENTIALS),
                    $this->apiHost,
                    $this->itemSummarySearchCache,
                ]
            );
    }
}
