<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use ChristianBrown\EBay\Browse\Api\ItemApi;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApi;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApi;
use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Http\ApiHostInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ApiClientServiceRegistrar implements ApiClientServiceRegistrarInterface
{
    private ApiHostInterface $apiHost;

    public function __construct(ApiHostInterface $apiHost)
    {
        $this->apiHost = $apiHost;
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
                ]
            );
    }
}
