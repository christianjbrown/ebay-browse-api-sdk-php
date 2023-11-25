<?php

declare(strict_types=1);

namespace ChristianBrown\eBay\FindServiceApi\Model;

interface ItemInterface extends ModelInterface
{
    public function getItemId(): ?int;
    public function setItemId(?int $itemId): self;
}
