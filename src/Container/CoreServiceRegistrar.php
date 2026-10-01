<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Container;

use ChristianBrown\ApiClient\ApiClientInterface;
use ChristianBrown\ApiClient\JsonApiRequestSenderInterface;
use ChristianBrown\EBay\Browse\Auth\Credentials;
use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Http\ApiHostInterface;
use ChristianBrown\EBay\Browse\MarketplaceInterface;
use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;
use ChristianBrown\OAuth2Client\ClientCredentialsTokenManagerFactoryInterface;
use ChristianBrown\OAuth2Client\ClientCredentialsTokenManagerInterface;
use ChristianBrown\OAuth2Client\Lock\LockInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CoreServiceRegistrar implements CoreServiceRegistrarInterface
{
    private TtlAwareKeyValueStoreInterface $accessTokenStore;
    private ApiClientInterface $apiClient;
    private ApiHostInterface $apiHost;
    private string $clientId;
    private string $clientSecret;
    private LockInterface $lock;
    private MarketplaceInterface $marketplace;
    private ClientCredentialsTokenManagerFactoryInterface $tokenManagerFactory;

    public function __construct(string $clientId, string $clientSecret, MarketplaceInterface $marketplace, TtlAwareKeyValueStoreInterface $accessTokenStore, ApiHostInterface $apiHost, ApiClientInterface $apiClient, ClientCredentialsTokenManagerFactoryInterface $tokenManagerFactory, LockInterface $lock)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->marketplace = $marketplace;
        $this->accessTokenStore = $accessTokenStore;
        $this->apiHost = $apiHost;
        $this->apiClient = $apiClient;
        $this->tokenManagerFactory = $tokenManagerFactory;
        $this->lock = $lock;
    }

    public function register(ContainerBuilder $container): void
    {
        $container->set(BrowseInterface::SERVICE_API_CLIENT, $this->apiClient);
        $container->register(BrowseInterface::SERVICE_JSON_API_REQUEST_SENDER, JsonApiRequestSenderInterface::class)
            ->setFactory([new Reference(BrowseInterface::SERVICE_API_CLIENT), 'getJsonApiRequestSender']);

        $container->register(BrowseInterface::SERVICE_CLIENT_CREDENTIALS_TOKEN_MANAGER, ClientCredentialsTokenManagerInterface::class)
            ->setFactory([$this->tokenManagerFactory, 'create'])
            ->setArguments(
                [
                    $container->getDefinition(BrowseInterface::SERVICE_JSON_API_REQUEST_SENDER),
                    $this->accessTokenStore,
                    $this->apiHost->oauthTokenUrl(),
                    $this->lock,
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
