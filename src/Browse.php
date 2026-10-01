<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse;

use ChristianBrown\EBay\Browse\Api\ItemApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemCompatibilityApiInterface;
use ChristianBrown\EBay\Browse\Api\ItemSummaryApiInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class Browse implements BrowseInterface
{
    private ContainerInterface $container;

    /**
     * @param ContainerInterface $container Holds the API client services under the BrowseInterface::SERVICE_* ids; BrowseFactory builds one
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
