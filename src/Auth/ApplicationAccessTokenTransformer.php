<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Auth;

use ChristianBrown\OAuth2Client\Model\AccessTokenInterface;
use ChristianBrown\OAuth2Client\Model\AccessTokenType;
use ChristianBrown\OAuth2Client\Model\Exception\BadResponsePayloadFieldExceptionInterface;
use ChristianBrown\OAuth2Client\Transformer\AccessTokenTransformerInterface;

final class ApplicationAccessTokenTransformer implements ApplicationAccessTokenTransformerInterface
{
    private AccessTokenTransformerInterface $accessTokenTransformer;

    public function __construct(AccessTokenTransformerInterface $accessTokenTransformer)
    {
        $this->accessTokenTransformer = $accessTokenTransformer;
    }

    /**
     * @param array<array-key, mixed> $data
     *
     * @throws BadResponsePayloadFieldExceptionInterface
     */
    public function transform(array $data): AccessTokenInterface
    {
        return $this->accessTokenTransformer->transform(self::normaliseTokenType($data));
    }

    /**
     * eBay's token endpoint answers a client-credentials grant with
     * `token_type: "Application Access Token"` instead of RFC 6749's `Bearer`.
     * The token itself is an ordinary bearer token, so the field is rewritten
     * before the shared OAuth2 transformer, which only knows `Bearer`, sees it.
     *
     * @param array<array-key, mixed> $data
     *
     * @return array<array-key, mixed>
     */
    private static function normaliseTokenType(array $data): array
    {
        if (!isset($data[self::KEY_TOKEN_TYPE])) {
            return $data;
        }
        if (self::TOKEN_TYPE_APPLICATION_ACCESS !== $data[self::KEY_TOKEN_TYPE]) {
            return $data;
        }
        $data[self::KEY_TOKEN_TYPE] = AccessTokenType::BEARER->value;

        return $data;
    }
}
