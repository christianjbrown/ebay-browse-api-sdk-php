<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

use ChristianBrown\eBay\FindServiceApi\Model\ItemInterface;

interface ItemTransformerInterface extends ObjectTransformerInterface
{
    public const string DATA_KEY_ITEM_ID = 'itemId';

    public function transform(array $data): ItemInterface;
}
