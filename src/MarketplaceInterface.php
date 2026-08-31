<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse;

use ChristianBrown\EBay\Browse\Enums\MarketplaceId;

interface MarketplaceInterface
{
    public const string HEADER_KEY_ACCEPT_LANGUAGE = 'Accept-Language';
    public const string HEADER_KEY_END_USER_CONTEXT = 'X-EBAY-C-ENDUSERCTX';
    public const string HEADER_KEY_MARKETPLACE_ID = 'X-EBAY-C-MARKETPLACE-ID';

    public function getAcceptLanguage(): ?string;

    public function getEndUserContext(): ?string;

    public function getMarketplaceId(): MarketplaceId;

    /**
     * Builds the marketplace headers every Browse API request carries: the
     * mandatory marketplace id, plus the optional end-user context and
     * `Accept-Language` when they were supplied.
     *
     * @return array<string, string>
     */
    public function toHeaders(): array;
}
