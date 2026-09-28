<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Http;

use function sprintf;

final class ApiHost implements ApiHostInterface
{
    private string $browseApiBaseUrl;
    private string $oauthTokenUrl;

    public function __construct(string $browseApiBaseUrl, string $oauthTokenUrl)
    {
        $this->browseApiBaseUrl = $browseApiBaseUrl;
        $this->oauthTokenUrl = $oauthTokenUrl;
    }

    public function browseApiUrl(string $path): string
    {
        return sprintf('%s%s', $this->browseApiBaseUrl, $path);
    }

    public function oauthTokenUrl(): string
    {
        return $this->oauthTokenUrl;
    }

    public static function production(): self
    {
        return new self(self::BROWSE_API_BASE_URL_PRODUCTION, self::OAUTH_TOKEN_URL_PRODUCTION);
    }

    public static function sandbox(): self
    {
        return new self(self::BROWSE_API_BASE_URL_SANDBOX, self::OAUTH_TOKEN_URL_SANDBOX);
    }
}
