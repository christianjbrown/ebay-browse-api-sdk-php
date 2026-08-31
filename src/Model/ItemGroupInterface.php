<?php

declare(strict_types=1);

namespace ChristianBrown\EBay\Browse\Model;

interface ItemGroupInterface
{
    /**
     * @return array<int, CommonDescriptionInterface>
     */
    public function getCommonDescriptions(): array;

    /**
     * @return array<int, ItemInterface>
     */
    public function getItems(): array;

    /**
     * @return array<int, ErrorInterface>
     */
    public function getWarnings(): array;

    /**
     * @param array<int, CommonDescriptionInterface> $value
     */
    public function setCommonDescriptions(array $value): self;

    /**
     * @param array<int, ItemInterface> $value
     */
    public function setItems(array $value): self;

    /**
     * @param array<int, ErrorInterface> $value
     */
    public function setWarnings(array $value): self;
}
