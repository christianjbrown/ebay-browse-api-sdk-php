<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Auth;

use ChristianBrown\EBay\Browse\MarketplaceInterface;
use ChristianBrown\OAuth2Client\ClientCredentialsTokenManagerInterface;
use ChristianBrown\OAuth2Client\Model\Exception\BadResponsePayloadFieldExceptionInterface;
use ChristianBrown\OAuth2Client\Model\Exception\RequestExceptionInterface;

use function array_merge;
use function sprintf;

final class Credentials implements CredentialsInterface
{
    private string $basicAuthValue;
    private MarketplaceInterface $marketplace;
    private ClientCredentialsTokenManagerInterface $tokenManager;

    public function __construct(ClientCredentialsTokenManagerInterface $tokenManager, MarketplaceInterface $marketplace, string $clientId, string $clientSecret)
    {
        $this->tokenManager = $tokenManager;
        $this->marketplace = $marketplace;
        $this->basicAuthValue = sprintf(self::BASIC_AUTH_VALUE_SPRINTF, $clientId, $clientSecret);
    }

    /**
     * @throws BadResponsePayloadFieldExceptionInterface
     * @throws RequestExceptionInterface
     *
     * @return array<string, string>
     */
    public function toHeaders(): array
    {
        // The token manager returns the cached application token while it is
        // still valid, and otherwise exchanges the Basic credentials for a new one.
        $accessToken = $this->tokenManager->getAccessTokenFromBasicAuth($this->basicAuthValue, self::SCOPE);

        $headers = [
            self::HEADER_KEY_AUTHORIZATION => sprintf(self::AUTHORIZATION_HEADER_VALUE_SPRINTF, $accessToken->getAccessToken()),
        ];

        return array_merge($headers, $this->marketplace->toHeaders());
    }
}
