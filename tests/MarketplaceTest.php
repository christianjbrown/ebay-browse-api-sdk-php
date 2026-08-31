<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests;

use ChristianBrown\EBay\Browse\Enums\MarketplaceId;
use ChristianBrown\EBay\Browse\Marketplace;
use ChristianBrown\EBay\Browse\MarketplaceInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Marketplace::class)]
final class MarketplaceTest extends TestCase
{
    public function testToHeadersWithAcceptLanguageOnly(): void
    {
        $marketplace = new Marketplace(MarketplaceId::EBAY_DE, null, 'de-DE');

        self::assertNull($marketplace->getEndUserContext());
        self::assertSame('de-DE', $marketplace->getAcceptLanguage());
        self::assertSame(
            [
                MarketplaceInterface::HEADER_KEY_MARKETPLACE_ID => 'EBAY_DE',
                MarketplaceInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'de-DE',
            ],
            $marketplace->toHeaders()
        );
    }

    public function testToHeadersWithEndUserContextOnly(): void
    {
        $marketplace = new Marketplace(MarketplaceId::EBAY_US, 'affiliateCampaignId=5338');

        self::assertSame('affiliateCampaignId=5338', $marketplace->getEndUserContext());
        self::assertNull($marketplace->getAcceptLanguage());
        self::assertSame(
            [
                MarketplaceInterface::HEADER_KEY_MARKETPLACE_ID => 'EBAY_US',
                MarketplaceInterface::HEADER_KEY_END_USER_CONTEXT => 'affiliateCampaignId=5338',
            ],
            $marketplace->toHeaders()
        );
    }

    public function testToHeadersWithEveryHeader(): void
    {
        $marketplace = new Marketplace(MarketplaceId::EBAY_GB, 'contextualLocation=country%3DGB', 'en-GB');

        self::assertSame(
            [
                MarketplaceInterface::HEADER_KEY_MARKETPLACE_ID => 'EBAY_GB',
                MarketplaceInterface::HEADER_KEY_END_USER_CONTEXT => 'contextualLocation=country%3DGB',
                MarketplaceInterface::HEADER_KEY_ACCEPT_LANGUAGE => 'en-GB',
            ],
            $marketplace->toHeaders()
        );
    }

    public function testToHeadersWithMarketplaceIdOnly(): void
    {
        $marketplace = new Marketplace(MarketplaceId::EBAY_GB);

        self::assertSame(MarketplaceId::EBAY_GB, $marketplace->getMarketplaceId());
        self::assertSame(
            [MarketplaceInterface::HEADER_KEY_MARKETPLACE_ID => 'EBAY_GB'],
            $marketplace->toHeaders()
        );
    }
}
