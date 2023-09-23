<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService\Transformer;

use ChristianBrown\eBay\FindService\Model\Item;

interface ItemTransformerInterface extends DataTransformerInterface
{
    public const DATA_KEY_ITEM_ID = 'itemId';

    public function transform(array $data): Item;
}
