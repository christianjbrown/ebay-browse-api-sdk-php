<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Transformer;

final class ItemsTransformer implements ItemsTransformerInterface
{
    private ItemTransformerInterface $itemTransformer;

    public function __construct(ItemTransformerInterface $itemTransformer)
    {
        $this->itemTransformer = $itemTransformer;
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
