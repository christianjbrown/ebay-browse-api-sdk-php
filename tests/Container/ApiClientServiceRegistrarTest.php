<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Container;

use ChristianBrown\EBay\Browse\Api\ItemApi;
use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Container\ApiClientServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\ComposedTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\CoreServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\LeafTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Enums\MarketplaceId;
use ChristianBrown\EBay\Browse\Marketplace;
use ChristianBrown\KeyValueStore\MemoryKeyValueStore;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ApiClientServiceRegistrar::class)]
#[UsesClass(ComposedTransformerServiceRegistrar::class)]
#[UsesClass(CoreServiceRegistrar::class)]
#[UsesClass(LeafTransformerServiceRegistrar::class)]
#[UsesClass(Marketplace::class)]
final class ApiClientServiceRegistrarTest extends TestCase
{
    public function testRegisterBuildsEveryApiClient(): void
    {
        $container = new ContainerBuilder();
        (new CoreServiceRegistrar('client-id', 'client-secret', new Marketplace(MarketplaceId::EBAY_GB), new MemoryKeyValueStore()))->register($container);
        (new LeafTransformerServiceRegistrar())->register($container);
        (new ComposedTransformerServiceRegistrar())->register($container);
        $registrar = new ApiClientServiceRegistrar();

        $registrar->register($container);

        self::assertSame(ItemApi::class, $container->getDefinition(BrowseInterface::SERVICE_ITEM_API)->getClass());
    }
}
