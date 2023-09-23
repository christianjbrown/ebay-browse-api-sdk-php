<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindService\Transformer;

use ChristianBrown\eBay\FindService\Model\Item;

final class ItemTransformer implements ItemTransformerInterface
{
    public function transform(array $data): Item
    {
        $item = new Item();
        if (!empty($data[self::DATA_KEY_ITEM_ID][0]) && is_numeric($data[self::DATA_KEY_ITEM_ID][0])) {
            $item->itemId = (int) $data[self::DATA_KEY_ITEM_ID][0];
        }

        // @todo Lots more fields to transform if we need them..

        return $item;
    }
}
