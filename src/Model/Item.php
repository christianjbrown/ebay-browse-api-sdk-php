<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Model;

final class Item implements ItemInterface
{
    private ?int $itemId = null;

    public function getItemId(): ?int
    {
        return $this->itemId;
    }

    public function setItemId(?int $itemId): ItemInterface
    {
        $this->itemId = $itemId;

        return $this;
    }
}
