<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

final class ItemsTransformer implements ItemsTransformerInterface
{
    private ItemTransformer $itemTransformer;

    public function __construct()
    {
        $this->itemTransformer = new ItemTransformer();
    }

    public function transform(array $data): array
    {
        $items = [];
        foreach ($data as $itemData) {
            $items[] = $this->itemTransformer->transform($itemData);
        }

        return $items;
    }
}
