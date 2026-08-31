<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

final class ItemGroup implements ItemGroupInterface
{
    /**
     * @var array<int, CommonDescriptionInterface>
     */
    private array $commonDescriptions = [];

    /**
     * @var array<int, ItemInterface>
     */
    private array $items = [];

    /**
     * @var array<int, ErrorInterface>
     */
    private array $warnings = [];

    /**
     * @return array<int, CommonDescriptionInterface>
     */
    public function getCommonDescriptions(): array
    {
        return $this->commonDescriptions;
    }

    /**
     * @return array<int, ItemInterface>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array
    {
        return $this->warnings;
    }

    /**
     * @param array<int, CommonDescriptionInterface> $value
     */
    public function setCommonDescriptions(array $value): ItemGroupInterface
    {
        $this->commonDescriptions = $value;

        return $this;
    }

    /**
     * @param array<int, ItemInterface> $value
     */
    public function setItems(array $value): ItemGroupInterface
    {
        $this->items = $value;

        return $this;
    }

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): ItemGroupInterface
    {
        $this->warnings = $value;

        return $this;
    }
}
