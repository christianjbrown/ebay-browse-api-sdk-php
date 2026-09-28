<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Container;

use ChristianBrown\EBay\Browse\Container\ContainerFactory;
use ChristianBrown\EBay\Browse\Container\ServiceRegistrarInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

#[CoversClass(ContainerFactory::class)]
final class ContainerFactoryTest extends TestCase
{
    public function testCreateRegistersEveryRegistrarOnTheSameContainer(): void
    {
        $seenContainers = [];

        $first = $this->createMock(ServiceRegistrarInterface::class);
        $first->expects(self::once())
            ->method('register')
            ->willReturnCallback(static function (ContainerBuilder $container) use (&$seenContainers): void {
                $seenContainers[] = $container;
            });

        $second = $this->createMock(ServiceRegistrarInterface::class);
        $second->expects(self::once())
            ->method('register')
            ->willReturnCallback(static function (ContainerBuilder $container) use (&$seenContainers): void {
                $seenContainers[] = $container;
            });

        $factory = new ContainerFactory([$first, $second]);

        $container = $factory->create();

        self::assertInstanceOf(ContainerBuilder::class, $container);
        self::assertSame([$container, $container], $seenContainers);
    }

    public function testCreateWithNoRegistrarsReturnsAnEmptyContainer(): void
    {
        $factory = new ContainerFactory([]);

        self::assertInstanceOf(ContainerBuilder::class, $factory->create());
    }
}
