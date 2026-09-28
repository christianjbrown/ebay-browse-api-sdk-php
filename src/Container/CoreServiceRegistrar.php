<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use ChristianBrown\ApiClient\ApiClient;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Auth\Credentials;
use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Http\ApiHostInterface;
use ChristianBrown\EBay\Browse\MarketplaceInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use ChristianBrown\OAuth2Client\ClientCredentialsTokenManager;
use ChristianBrown\OAuth2Client\Transformer\AccessTokenTransformer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CoreServiceRegistrar implements CoreServiceRegistrarInterface
{
    private TtlAwareKeyValueStoreInterface $accessTokenStore;
    private ApiHostInterface $apiHost;
    private string $clientId;
    private string $clientSecret;
    private MarketplaceInterface $marketplace;

    public function __construct(string $clientId, string $clientSecret, MarketplaceInterface $marketplace, TtlAwareKeyValueStoreInterface $accessTokenStore, ApiHostInterface $apiHost)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->marketplace = $marketplace;
        $this->accessTokenStore = $accessTokenStore;
        $this->apiHost = $apiHost;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->register(BrowseInterface::SERVICE_API_CLIENT, ApiClient::class);
        $container->register(BrowseInterface::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(BrowseInterface::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);

        $container->register(BrowseInterface::SERVICE_ACCESS_TOKEN_TRANSFORMER, AccessTokenTransformer::class);
        $container->register(BrowseInterface::SERVICE_CLIENT_CREDENTIALS_TOKEN_MANAGER, ClientCredentialsTokenManager::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->accessTokenStore,
                    $container->getDefinition(BrowseInterface::SERVICE_ACCESS_TOKEN_TRANSFORMER),
                    $this->apiHost->oauthTokenUrl(),
                ]
            );

        $container->register(BrowseInterface::SERVICE_CREDENTIALS, Credentials::class)
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_CLIENT_CREDENTIALS_TOKEN_MANAGER),
                    $this->marketplace,
                    $this->clientId,
                    $this->clientSecret,
                ]
            );
    }
}
