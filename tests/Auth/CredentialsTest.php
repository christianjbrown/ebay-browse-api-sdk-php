<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Tests\Auth;

use ChristianBrown\EBay\Browse\Auth\Credentials;
use ChristianBrown\EBay\Browse\Auth\CredentialsInterface;
use ChristianBrown\EBay\Browse\MarketplaceInterface;
use ChristianBrown\OAuth2Client\ClientCredentialsTokenManagerInterface;
use ChristianBrown\OAuth2Client\Model\AccessTokenInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Credentials::class)]
final class CredentialsTest extends TestCase
{
    public function testToHeaders(): void
    {
        $accessToken = self::createStub(AccessTokenInterface::class);
        $accessToken->method('getAccessToken')->willReturn('test-access-token');

        $tokenManager = self::createMock(ClientCredentialsTokenManagerInterface::class);
        $tokenManager->expects(self::once())->method('getAccessTokenFromBasicAuth')
            ->with('test-client-id:test-client-secret', CredentialsInterface::SCOPE)
            ->willReturn($accessToken);

        $marketplace = self::createStub(MarketplaceInterface::class);
        $marketplace->method('toHeaders')
            ->willReturn([MarketplaceInterface::HEADER_KEY_MARKETPLACE_ID => 'EBAY_GB']);

        $credentials = new Credentials($tokenManager, $marketplace, 'test-client-id', 'test-client-secret');

        self::assertSame(
            [
                CredentialsInterface::HEADER_KEY_AUTHORIZATION => 'Bearer test-access-token',
                MarketplaceInterface::HEADER_KEY_MARKETPLACE_ID => 'EBAY_GB',
            ],
            $credentials->toHeaders()
        );
    }

    public function testToHeadersWithScope(): void
    {
        $accessToken = self::createStub(AccessTokenInterface::class);
        $accessToken->method('getAccessToken')->willReturn('test-access-token');

        $tokenManager = self::createMock(ClientCredentialsTokenManagerInterface::class);
        $tokenManager->expects(self::once())->method('getAccessTokenFromBasicAuth')
            ->with('test-client-id:test-client-secret', 'test-scope')
            ->willReturn($accessToken);

        $marketplace = self::createStub(MarketplaceInterface::class);
        $marketplace->method('toHeaders')
            ->willReturn([MarketplaceInterface::HEADER_KEY_MARKETPLACE_ID => 'EBAY_GB']);

        $credentials = new Credentials($tokenManager, $marketplace, 'test-client-id', 'test-client-secret');

        self::assertSame(
            [
                CredentialsInterface::HEADER_KEY_AUTHORIZATION => 'Bearer test-access-token',
                MarketplaceInterface::HEADER_KEY_MARKETPLACE_ID => 'EBAY_GB',
            ],
            $credentials->toHeaders('test-scope')
        );
    }
}
