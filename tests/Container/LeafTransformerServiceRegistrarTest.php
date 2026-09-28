<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Container;

use ChristianBrown\EBay\Browse\BrowseInterface;
use ChristianBrown\EBay\Browse\Container\LeafTransformerServiceRegistrar;
use ChristianBrown\EBay\Browse\Transformer\StringsTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(LeafTransformerServiceRegistrar::class)]
#[UsesClass(StringsTransformer::class)]
final class LeafTransformerServiceRegistrarTest extends TestCase
{
    public function testRegisterBuildsEveryLeafTransformer(): void
    {
        $container = new ContainerBuilder();
        $registrar = new LeafTransformerServiceRegistrar();

        $registrar->register($container);

        self::assertInstanceOf(StringsTransformer::class, $container->get(BrowseInterface::SERVICE_STRINGS_TRANSFORMER));
    }
}
