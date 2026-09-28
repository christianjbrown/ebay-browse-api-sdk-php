<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse;

use ChristianBrown\EBay\Browse\Api\ItemApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApiInterface;
use ChristianBrown\EBay\Browse\Container\ApiClientServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\ComposedTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\ContainerFactory;
use ChristianBrown\EBay\Browse\Container\CoreServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\LeafTransformerServiceRegistrar;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class Browse implements BrowseInterface
{
    private ContainerBuilder $container;

    public function __construct(string $clientId, string $clientSecret, MarketplaceInterface $marketplace, TtlAwareKeyValueStoreInterface $accessTokenStore)
    {
        // The registrars run in dependency order: core (credentials and the
        // OAuth2 machinery) must exist before any transformer or client
        // references it, leaf transformers before the composed transformers
        // that wrap them, and both transformer groups before the API clients
        // that consume them.
        $containerFactory = new ContainerFactory(
            [
                new CoreServiceRegistrar($clientId, $clientSecret, $marketplace, $accessTokenStore),
                new LeafTransformerServiceRegistrar(),
                new ComposedTransformerServiceRegistrar(),
                new ApiClientServiceRegistrar(),
            ],
        );
        $this->container = $containerFactory->create();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getItemApi(): ItemApiInterface
    {
        /**
         * @var ItemApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_ITEM_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getItemCompatibilityApi(): ItemCompatibilityApiInterface
    {
        /**
         * @var ItemCompatibilityApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_ITEM_COMPATIBILITY_API);

        return $service;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getItemSummaryApi(): ItemSummaryApiInterface
    {
        /**
         * @var ItemSummaryApiInterface $service
         */
        $service = $this->container->get(self::SERVICE_ITEM_SUMMARY_API);

        return $service;
    }
}
