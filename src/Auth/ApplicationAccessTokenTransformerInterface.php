<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Auth;

use ChristianBrown\OAuth2Client\Transformer\AccessTokenTransformerInterface;

interface ApplicationAccessTokenTransformerInterface extends AccessTokenTransformerInterface
{
    public const string TOKEN_TYPE_APPLICATION_ACCESS = 'Application Access Token';
}
