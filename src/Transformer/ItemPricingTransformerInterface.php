<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

interface ItemPricingTransformerInterface
{
    /**
     * Prices, bids, taxes, coupons, payment methods and buying options.
     *
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void;
}
