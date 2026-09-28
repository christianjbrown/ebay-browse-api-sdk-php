<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Auth;

use ChristianBrown\OAuth2Client\Model\Exception\BadResponsePayloadFieldExceptionInterface;
use ChristianBrown\OAuth2Client\Model\Exception\RequestExceptionInterface;

interface CredentialsInterface
{
    public const string AUTHORIZATION_HEADER_VALUE_SPRINTF = 'Bearer %s';
    public const string BASIC_AUTH_VALUE_SPRINTF = '%s:%s';
    public const string HEADER_KEY_AUTHORIZATION = 'Authorization';
    public const string SCOPE = 'https://api.ebay.com/oauth/api_scope';

    /**
     * Builds the headers every Browse API request needs: an application
     * (client-credentials) OAuth2 bearer token as `Authorization`, plus the
     * marketplace headers.
     *
     * @param null|string $scope The OAuth2 scope(s) to request, space-separated.
     *                           Defaults to self::SCOPE; a call that needs a
     *                           broader grant (e.g. getItems()'s Limited
     *                           Release bulk scope) passes its own value so
     *                           existing callers are unaffected.
     *
     * @throws BadResponsePayloadFieldExceptionInterface
     * @throws RequestExceptionInterface
     *
     * @return array<string, string>
     */
    public function toHeaders(?string $scope = null): array;
}
