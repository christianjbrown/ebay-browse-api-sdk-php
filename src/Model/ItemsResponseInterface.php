<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ItemsResponseInterface
{
    /**
     * @return array<int, ItemInterface>
     */
    public function getItems(): array;

    public function getTotal(): ?int;

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array;

    /**
     * @param array<int, ItemInterface> $value
     */
    public function setItems(array $value): self;

    public function setTotal(?int $value): self;

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): self;
}
