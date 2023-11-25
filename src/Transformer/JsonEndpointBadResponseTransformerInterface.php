<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

use ChristianBrown\JsonApiClient\BadResponseTransformerInterface;

interface JsonEndpointBadResponseTransformerInterface extends BadResponseTransformerInterface
{
    public const ERROR_DESCRIPTION_KEY = 'error_description';
    public const FRIENDLY_NAME = 'eBay\'s Finding API';
    public const MESSAGE_FROM_ERROR_DESCRIPTION = 'Got a %d response from %s: %s';
    public const MESSAGE_GENERIC = 'Got a %d response from %s';
}
