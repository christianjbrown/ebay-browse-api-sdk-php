<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Container;

use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Container\ComposedTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Container\LeafTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Transformer\SearchPagedCollectionTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ComposedTransformerServiceRegistrar::class)]
#[UsesClass(LeafTransformerServiceRegistrar::class)]
final class ComposedTransformerServiceRegistrarTest extends TestCase
{
    public function testRegisterBuildsEveryComposedTransformer(): void
    {
        $container = new ContainerBuilder();
        (new LeafTransformerServiceRegistrar())->register($container);
        $registrar = new ComposedTransformerServiceRegistrar();

        $registrar->register($container);

        self::assertSame(SearchPagedCollectionTransformer::class, $container->getDefinition(BrowseInterface::SERVICE_SEARCH_PAGED_COLLECTION_TRANSFORMER)->getClass());
    }
}
