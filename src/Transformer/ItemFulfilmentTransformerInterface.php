<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

interface ItemFulfilmentTransformerInterface
{
    /**
     * Shipping, returns, location, availability and checkout options.
     *
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void;
}
