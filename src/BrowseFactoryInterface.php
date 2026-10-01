<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse;

use ChristianBrown\KeyValueStore\TtlAwareKeyValueStoreInterface;

interface BrowseFactoryInterface
{
    /**
     * Builds a fully wired Browse facade for one set of eBay application credentials.
     */
    public function create(string $clientId, string $clientSecret, MarketplaceInterface $marketplace, TtlAwareKeyValueStoreInterface $accessTokenStore): BrowseInterface;
}
