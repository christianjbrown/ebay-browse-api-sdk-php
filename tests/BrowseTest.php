<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests;

use ChristianBrown\EBay\Browse\Api\ItemApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApiInterface;
use ChristianBrown\EBay\Browse\Browse;
use ChristianBrown\EBay\Browse\BrowseInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

#[CoversClass(Browse::class)]
final class BrowseTest extends TestCase
{
    public function testItemApi(): void
    {
        $itemApi = self::createStub(ItemApiInterface::class);

        self::assertSame($itemApi, $this->buildBrowse(BrowseInterface::SERVICE_ITEM_API, $itemApi)->getItemApi());
    }

    public function testItemCompatibilityApi(): void
    {
        $itemCompatibilityApi = self::createStub(ItemCompatibilityApiInterface::class);

        self::assertSame($itemCompatibilityApi, $this->buildBrowse(BrowseInterface::SERVICE_ITEM_COMPATIBILITY_API, $itemCompatibilityApi)->getItemCompatibilityApi());
    }

    public function testItemSummaryApi(): void
    {
        $itemSummaryApi = self::createStub(ItemSummaryApiInterface::class);

        self::assertSame($itemSummaryApi, $this->buildBrowse(BrowseInterface::SERVICE_ITEM_SUMMARY_API, $itemSummaryApi)->getItemSummaryApi());
    }

    private function buildBrowse(string $serviceId, object $service): Browse
    {
        $container = self::createMock(ContainerInterface::class);
        $container->expects(self::once())->method('get')->with($serviceId)->willReturn($service);

        return new Browse($container);
    }
}
