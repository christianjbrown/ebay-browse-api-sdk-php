<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Transformer;

use ChristianBrown\EBay\Browse\Model\Item;

interface ItemDescriptionTransformerInterface
{
    /**
     * Text and attribute fields: titles, descriptions, brand, size, category and aspects.
     *
     * @phpstan-param mixed[] $data
     */
    public function apply(Item $item, array $data): void;
}
