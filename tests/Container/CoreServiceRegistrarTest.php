<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Container;

use ChristianBrown\EBay\Browse\Auth\Credentials;
use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Container\CoreServiceRegistrar;
use ChristianBrown\EBay\Browse\Enums\MarketplaceId;
use ChristianBrown\EBay\Browse\Http\ApiHost;
use ChristianBrown\EBay\Browse\Marketplace;
use ChristianBrown\KeyValueStore\MemoryKeyValueStore;
use ChristianBrown\OAuth2Client\ClientCredentialsTokenManager;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(CoreServiceRegistrar::class)]
#[UsesClass(ApiHost::class)]
#[UsesClass(Credentials::class)]
#[UsesClass(Marketplace::class)]
final class CoreServiceRegistrarTest extends TestCase
{
    public function testRegisterBuildsCredentials(): void
    {
        $container = new ContainerBuilder();
        $registrar = new CoreServiceRegistrar('client-id', 'client-secret', new Marketplace(MarketplaceId::EBAY_GB), new MemoryKeyValueStore(), ApiHost::production());

        $registrar->register($container);

        self::assertInstanceOf(Credentials::class, $container->get(BrowseInterface::SERVICE_CREDENTIALS));
    }

    public function testRegisterUsesTheGivenApiHostForTheOauthTokenUrl(): void
    {
        $container = new ContainerBuilder();
        $registrar = new CoreServiceRegistrar('client-id', 'client-secret', new Marketplace(MarketplaceId::EBAY_GB), new MemoryKeyValueStore(), ApiHost::sandbox());

        $registrar->register($container);

        $definition = $container->getDefinition(BrowseInterface::SERVICE_CLIENT_CREDENTIALS_TOKEN_MANAGER);

        self::assertSame(ClientCredentialsTokenManager::class, $definition->getClass());
        self::assertSame(ApiHost::sandbox()->oauthTokenUrl(), $definition->getArgument(3));
    }
}
