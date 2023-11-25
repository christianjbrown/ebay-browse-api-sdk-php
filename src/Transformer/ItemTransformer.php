<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

use ChristianBrown\eBay\FindServiceApi\Model\Item;
use ChristianBrown\eBay\FindServiceApi\Model\ItemInterface;

final class ItemTransformer implements ItemTransformerInterface
{
    public function transform(array $data): ItemInterface
    {
        $item = new Item();
        if (!empty($data[self::DATA_KEY_ITEM_ID][0]) && is_numeric($data[self::DATA_KEY_ITEM_ID][0])) {
            $item->setItemId((int) $data[self::DATA_KEY_ITEM_ID][0]);
        }

        return $item;
    }
}
