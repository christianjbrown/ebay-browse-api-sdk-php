<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class CommonDescription implements CommonDescriptionInterface
{
    private ?string $description = null;

    /**
     * @var array<int, string>
     */
    private array $itemIds = [];

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array<int, string>
     */
    public function getItemIds(): array
    {
        return $this->itemIds;
    }

    public function setDescription(?string $value): CommonDescriptionInterface
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setItemIds(array $value): CommonDescriptionInterface
    {
        $this->itemIds = $value;

        return $this;
    }
}
