<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Container;

use ChristianBrown\ApiClient\ApiClientFactory;
use ChristianBrown\ApiClient\ClientOptions;
use ChristianBrown\EBay\Browse\Api\ItemApi;
use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Cache\ArrayKeyedCache;
use ChristianBrown\EBay\Browse\Container\ApiClientServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\ComposedTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\CoreServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\LeafTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Enums\MarketplaceId;
use ChristianBrown\EBay\Browse\Http\ApiHost;
use ChristianBrown\EBay\Browse\Marketplace;
use ChristianBrown\EBay\Browse\Model\ItemGroupInterface;
use ChristianBrown\EBay\Browse\Model\ItemInterface;
use ChristianBrown\EBay\Browse\Model\ItemsResponseInterface;
use ChristianBrown\EBay\Browse\Model\SearchPagedCollectionInterface;
use ChristianBrown\KeyValueStore\MemoryKeyValueStore;
use ChristianBrown\OAuth2Client\ClientCredentialsTokenManagerFactory;
use ChristianBrown\OAuth2Client\Lock\NullLock;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Clock\MockClock;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ApiClientServiceRegistrar::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(ArrayKeyedCache::class)]
#[UsesClass(ComposedTransformerServiceRegistrar::class)]
#[UsesClass(CoreServiceRegistrar::class)]
#[UsesClass(LeafTransformerServiceRegistrar::class)]
#[UsesClass(Marketplace::class)]
final class ApiClientServiceRegistrarTest extends TestCase
{
    public function testRegisterBuildsEveryApiClient(): void
    {
        $apiHost = ApiHost::production();

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
        $container = new ContainerBuilder();
        (new CoreServiceRegistrar('client-id', 'client-secret', new Marketplace(MarketplaceId::EBAY_GB), new MemoryKeyValueStore(new MockClock()), $apiHost, (new ApiClientFactory(new ClientOptions()))->create(), new ClientCredentialsTokenManagerFactory(new MockClock()), new NullLock()))->register($container);
        (new LeafTransformerServiceRegistrar())->register($container);
        (new ComposedTransformerServiceRegistrar())->register($container);
        $registrar = new ApiClientServiceRegistrar($apiHost, $itemOneCache, $itemLegacyCache, $itemGroupCache, $itemSummarySearchCache, $itemsCache);

        $registrar->register($container);

        $itemApiDefinition = $container->getDefinition(BrowseInterface::SERVICE_ITEM_API);
        $itemSummaryApiDefinition = $container->getDefinition(BrowseInterface::SERVICE_ITEM_SUMMARY_API);

        self::assertSame(ItemApi::class, $itemApiDefinition->getClass());
        self::assertSame($apiHost, $itemApiDefinition->getArgument(4));
        self::assertSame($itemOneCache, $itemApiDefinition->getArgument(5));
        self::assertSame($itemLegacyCache, $itemApiDefinition->getArgument(6));
        self::assertSame($itemGroupCache, $itemApiDefinition->getArgument(7));
        self::assertSame($container->getDefinition(BrowseInterface::SERVICE_ITEMS_RESPONSE_TRANSFORMER), $itemApiDefinition->getArgument(8));
        self::assertSame($itemsCache, $itemApiDefinition->getArgument(9));
        self::assertSame($itemSummarySearchCache, $itemSummaryApiDefinition->getArgument(4));
    }

    public function testRegisteredGraphCompilesWithEveryReferenceResolvable(): void
    {
        $apiHost = ApiHost::production();

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

        $container = new ContainerBuilder();
        (new CoreServiceRegistrar('client-id', 'client-secret', new Marketplace(MarketplaceId::EBAY_GB), new MemoryKeyValueStore(new MockClock()), $apiHost, (new ApiClientFactory(new ClientOptions()))->create(), new ClientCredentialsTokenManagerFactory(new MockClock()), new NullLock()))->register($container);
        (new LeafTransformerServiceRegistrar())->register($container);
        (new ComposedTransformerServiceRegistrar())->register($container);
        (new ApiClientServiceRegistrar($apiHost, $itemOneCache, $itemLegacyCache, $itemGroupCache, $itemSummarySearchCache, $itemsCache))->register($container);

        $container->compile();

        self::assertTrue($container->isCompiled());
    }
}
