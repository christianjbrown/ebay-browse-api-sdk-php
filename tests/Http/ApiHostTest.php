<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Http;

use ChristianBrown\EBay\Browse\Http\ApiHost;
use ChristianBrown\EBay\Browse\Http\ApiHostInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApiHost::class)]
final class ApiHostTest extends TestCase
{
    public function testCustomHostBuildsUrlsFromItsOwnBases(): void
    {
        $apiHost = new ApiHost('https://example.test/buy/browse/v1', 'https://example.test/oauth2/token');

        self::assertSame('https://example.test/buy/browse/v1/item/%s', $apiHost->browseApiUrl('/item/%s'));
        self::assertSame('https://example.test/oauth2/token', $apiHost->oauthTokenUrl());
    }

    public function testProductionUsesTheProductionEbayHosts(): void
    {
        $apiHost = ApiHost::production();

        self::assertSame(ApiHostInterface::BROWSE_API_BASE_URL_PRODUCTION.'/item/v1|1|0', $apiHost->browseApiUrl('/item/v1|1|0'));
        self::assertSame(ApiHostInterface::OAUTH_TOKEN_URL_PRODUCTION, $apiHost->oauthTokenUrl());
    }

    public function testSandboxUsesTheSandboxEbayHosts(): void
    {
        $apiHost = ApiHost::sandbox();

        self::assertSame(ApiHostInterface::BROWSE_API_BASE_URL_SANDBOX.'/item/v1|1|0', $apiHost->browseApiUrl('/item/v1|1|0'));
        self::assertSame(ApiHostInterface::OAUTH_TOKEN_URL_SANDBOX, $apiHost->oauthTokenUrl());
    }
}
