<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse;

use ChristianBrown\ApiClient\ApiClientFactory;
use ChristianBrown\ApiClient\ClientOptions;
use ChristianBrown\EBay\Browse\Cache\ArrayKeyedCache;
use ChristianBrown\EBay\Browse\Container\ApiClientServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\ComposedTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\ContainerFactory;
use ChristianBrown\EBay\Browse\Container\CoreServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\LeafTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Http\ApiHostInterface;
use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ItemsResponseInterface;
use ChristianBrown\EBay\Browse\Model\SearchPagedCollectionInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use ChristianBrown\OAuth2Client\ClientCredentialsTokenManagerFactory;
use ChristianBrown\OAuth2Client\Lock\NullLock;
use Symfony\Component\Clock\NativeClock;

/**
 * The composition root: the one place that builds the SDK's object graph.
 */
final class BrowseFactory implements BrowseFactoryInterface
{
    private ApiHostInterface $apiHost;

    /**
     * @param ApiHostInterface $apiHost Pass ApiHost::production() or ApiHost::sandbox(); it switches every client and
     *                                  the OAuth token exchange between eBay's production and sandbox gateways
     */
    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
    }

    public function create(string $clientId, string $clientSecret, MarketplaceInterface $marketplace, TtlAwareKeyValueStoreInterface $accessTokenStore): BrowseInterface
    {
        /**
         * @var ArrayKeyedCache<ItemInterface> $itemOneCache
         */
        $itemOneCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemInterface> $itemLegacyCache
         */
        $itemLegacyCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemGroupInterface> $itemGroupCache
         */
        $itemGroupCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<SearchPagedCollectionInterface> $itemSummarySearchCache
         */
        $itemSummarySearchCache = new ArrayKeyedCache();

        /**
         * @var ArrayKeyedCache<ItemsResponseInterface> $itemsCache
         */
        $itemsCache = new ArrayKeyedCache();

        // The SDK takes no lock, so token refreshes are not serialised across
        // processes: NullLock never blocks. The registrars run in dependency order: core (credentials and the
        // OAuth2 machinery) must exist before any transformer or client
        // references it, leaf transformers before the composed transformers
        // that wrap them, and both transformer groups before the API clients
        // that consume them.
        $containerFactory = new ContainerFactory(
            [
                new CoreServiceRegistrar($clientId, $clientSecret, $marketplace, $accessTokenStore, $this->apiHost, (new ApiClientFactory(new ClientOptions()))->create(), new ClientCredentialsTokenManagerFactory(new NativeClock()), new NullLock()),
                new LeafTransformerServiceRegistrar(),
                new ComposedTransformerServiceRegistrar(),
                new ApiClientServiceRegistrar($this->apiHost, $itemOneCache, $itemLegacyCache, $itemGroupCache, $itemSummarySearchCache, $itemsCache),
            ],
        );

        return new Browse($containerFactory->create());
    }
}
