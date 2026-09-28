<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Http;

interface ApiHostInterface
{
    public const string BROWSE_API_BASE_URL_PRODUCTION = 'https://api.ebay.com/buy/browse/v1';

    // eBay runs the Buy APIs, including Browse, through a different sandbox
    // gateway host than the rest of the platform: production is uniformly
    // api.ebay.com, but Buy API sandbox traffic goes to apiz.sandbox.ebay.com
    // while identity/OAuth sandbox traffic stays on api.sandbox.ebay.com.
    public const string BROWSE_API_BASE_URL_SANDBOX = 'https://apiz.sandbox.ebay.com/buy/browse/v1';
    public const string OAUTH_TOKEN_URL_PRODUCTION = 'https://api.ebay.com/identity/v1/oauth2/token';
    public const string OAUTH_TOKEN_URL_SANDBOX = 'https://api.sandbox.ebay.com/identity/v1/oauth2/token';

    /**
     * @param string $path A path beginning with a slash, e.g. '/item/%s'
     */
    public function browseApiUrl(string $path): string;

    public function oauthTokenUrl(): string;
}
