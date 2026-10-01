<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

interface ItemConditionTransformerInterface
{
    /**
     * The condition of the item and its descriptors.
     *
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void;
}
