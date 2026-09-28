<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ItemsResponse implements ItemsResponseInterface
{
    /**
     * @var array<int, ItemInterface>
     */
    private array $items = [];
    private ?int $total = null;

    /**
     * @var array<int, ErrorInterface>
     */
    private array $warnings = [];

    /**
     * @return array<int, ItemInterface>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * @param array<int, ItemInterface> $value
     */
    public function setItems(array $value): ItemsResponseInterface
    {
        $this->items = $value;

        return $this;
    }

    public function setTotal(?int $value): ItemsResponseInterface
    {
        $this->total = $value;

        return $this;
    }

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): ItemsResponseInterface
    {
        $this->warnings = $value;

        return $this;
    }
}
