<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

interface ItemProductTransformerInterface
{
    /**
     * The catalogue product, item group and review rating.
     *
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void;
}
